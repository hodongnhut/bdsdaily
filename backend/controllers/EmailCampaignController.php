<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\EmailLog;
use common\models\SalesContact;
use common\models\EmailCampaign;
use yii\web\NotFoundHttpException;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use yii\filters\AccessControl; 
use yii\filters\VerbFilter;

class EmailCampaignController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    // Create email campaign
    public function actionCreate()
    {
        $model = new EmailCampaign();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            Yii::$app->session->setFlash('success', 'Campaign created. It will be sent according to the schedule.');
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            Yii::$app->session->setFlash('success', 'Campaign created. It will be sent according to the schedule.');
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionToggleStatus($id)
    {
        $model = EmailCampaign::findOne($id);
        if ($model) {
            $model->status = $model->status === 'on' ? 'off' : 'on';
            $model->save();
            Yii::$app->session->setFlash('success', 'Campaign status updated.');
        }
        return $this->redirect(['index']);
    }

    // API for n8n to check and queue campaigns
    public function actionCheckSchedule()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $currentDay = date('N'); 
        // echo $currentDay; 
        $currentHour = date('H');
        // echo $currentHour; die;
        $campaigns = EmailCampaign::find()
            ->where(['send_day' => $currentDay, 'send_hour' => $currentHour, 'status' => 'on'])
            ->all();

        $queued = [];
        if (!empty($campaigns)) {
            foreach ($campaigns as $campaign) {
                $this->pushToQueue($campaign->id);
                $queued[] = $campaign->id;
            }
        }
        
        return ['status' => 'success', 'queued_campaigns' => $queued];
    }

    /**
     * Pushes emails for a campaign to the RabbitMQ queue.
     */
    private function pushToQueue($campaignId)
    {
        $rabbitMqConfig = Yii::$app->params['rabbitmq'];
        
        try {
            $connection = new AMQPStreamConnection(
                $rabbitMqConfig['host'],
                $rabbitMqConfig['port'],
                $rabbitMqConfig['username'],
                $rabbitMqConfig['password']
            );
            $channel = $connection->channel();
            $channel->queue_declare('email_queue', false, true, false, false);
        } catch (\Exception $e) {
            Yii::error("Failed to connect to RabbitMQ: {$e->getMessage()}", __METHOD__);
            return;
        }

        $campaign = EmailCampaign::findOne($campaignId);
        if (!$campaign) {
            Yii::error("Campaign ID {$campaignId} not found.", __METHOD__);
            $channel->close();
            $connection->close();
            return;
        }

        // Kiểm tra số email đã gửi trong ngày cho chiến dịch
        $sentToday = EmailLog::find()
            ->where([
                'campaign_id' => $campaign->id,
                'status' => 'sent'
            ])
            ->andWhere(['like', 'sent_at', date('Y-m-d')])
            ->count();

        $dailyLimit = ($campaign->limit ?? 100);
        $remainingLimit = $dailyLimit - $sentToday;

        if ($remainingLimit <= 0) {
            Yii::info("Daily limit reached for campaign ID {$campaign->id}. Sent: {$sentToday}/{$dailyLimit}", __METHOD__);
            $channel->close();
            $connection->close();
            return ['queued' => 0, 'message' => 'Daily limit reached'];
        }

        // Lấy tất cả email đã gửi cho chiến dịch này (không giới hạn ngày)
        $sentEmails = EmailLog::find()
            ->select('email')
            ->where(['campaign_id' => $campaign->id])
            ->column();

        // Chọn các liên hệ chưa nhận email từ chiến dịch này
        $limit = min($remainingLimit, 100);
        $recipients = SalesContact::find()
            ->select(['email', 'name', 'company_status', 'phone', 'phone1', 'zalo', 'area', 'address'])
            ->where(['not in', 'email', $sentEmails])
            ->orderBy('RAND()')
            ->limit($limit)
            ->all();

        if (empty($recipients)) {
            Yii::warning("No contacts available for campaign ID {$campaign->id}.", __METHOD__);
            $channel->close();
            $connection->close();
            return;
        }

        foreach ($recipients as $recipient) {
            $data = [
                'campaign_id' => $campaign->id,
                'name' => $recipient->name,
                'recipient_email' => $recipient->email,
                'company_status' => $recipient->company_status,
                'phone' => $recipient->phone,
                'phone1' => $recipient->phone1 ?? '',
                'zalo' => $recipient->zalo,
                'area' => $recipient->area,
                'address' => $recipient->address,
                'subject' => $campaign->subject,
                'content' => $campaign->content,
            ];
            try {
                $msg = new AMQPMessage(json_encode($data), ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
                $channel->basic_publish($msg, '', 'email_queue');
                Yii::info("Queued email for {$recipient->email} in campaign ID {$campaign->id}", __METHOD__);
            } catch (\Exception $e) {
                Yii::error("Failed to queue email for {$recipient->email}: {$e->getMessage()}", __METHOD__);
            }
        }

        try {
            $channel->close();
            $connection->close();
        } catch (\Exception $e) {
            Yii::error("Error closing RabbitMQ connection: {$e->getMessage()}", __METHOD__);
        }
    }


     /**
     * Previews the email template for a campaign.
     */
    public function actionPreview($id, $contact_id = null)
    {
        $campaign = $this->findModel($id);
        $contact = $contact_id ? SalesContact::findOne($contact_id) : new SalesContact([
            'name' => 'Sample Name',
            'email' => 'sample@example.com',
            'company_status' => 'Sample Company',
            'phone' => '1234567890',
            'phone1' => '0987654321',
            'zalo' => 'sample_zalo',
            'area' => 'Sample Area',
            'address' => 'Sample Address',
        ]);

        // Render the email template
        $content = $this->renderPartial('@common/mail/introduce-bdsdaily', [
            'name' => $contact->name,
            'email' => $contact->email,
            'content' => $campaign->content,
            'company_status' => $contact->company_status,
            'phone' => $contact->phone,
            'phone1' => $contact->phone1,
            'zalo' => $contact->zalo,
            'area' => $contact->area,
            'address' => $contact->address,
        ]);

        return $this->render('preview', [
            'campaign' => $campaign,
            'contact' => $contact,
            'content' => $content,
        ]);
    }


    public function actionIndex()
    {
        $campaigns = EmailCampaign::find()->all();
        return $this->render('index', ['campaigns' => $campaigns]);
    }

     /**
     * Deletes an existing SalesContact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SalesContact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return SalesContact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmailCampaign::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLogs()
    {
        $logs = EmailLog::find()->all();
        return $this->render('logs', ['logs' => $logs]);
    }
}

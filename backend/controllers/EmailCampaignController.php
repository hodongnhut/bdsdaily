<?php
// File: backend/controllers/EmailCampaignController.php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\EmailCampaign;
use common\models\EmailLog;
use common\models\SalesContact;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\web\NotFoundHttpException;

class EmailCampaignController extends Controller
{
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
        foreach ($campaigns as $campaign) {
            $this->pushToQueue($campaign->id);
            $queued[] = $campaign->id;
        }

        return ['status' => 'success', 'queued_campaigns' => $queued];
    }

    private function pushToQueue($campaignId)
    {
        $rabbitMqConfig = Yii::$app->params['rabbitmq'];
        
        $connection = new AMQPStreamConnection(
            $rabbitMqConfig['host'],
            $rabbitMqConfig['port'],
            $rabbitMqConfig['username'],
            $rabbitMqConfig['password']
        );

        $channel = $connection->channel();

        $channel->queue_declare('email_queue', false, true, false, false);


        $campaign = EmailCampaign::findOne($campaignId);

        $offset = 0;
        $limit = 500;
        while ($recipients = SalesContact::find()->select(['email', 'name'])->limit($limit)->offset($offset)->all()) {
            foreach ($recipients as $recipient) {
                $data = [
                    'campaign_id' => $campaign->id,
                    'name' => $recipient->name,
                    'recipient_email' => $recipient->email,
                    'subject' => $campaign->subject,
                    'content' => $campaign->content,
                ];
                $msg = new AMQPMessage(json_encode($data), ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
                $channel->basic_publish($msg, '', 'email_queue');
            }
            $offset += $limit;
        }

        $channel->close();
        $connection->close();
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

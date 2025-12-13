<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use common\models\EmailCampaign;
use common\models\SalesContact;
use common\models\EmailLog;

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
                'except' => ['check-schedule'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $identity = Yii::$app->user->identity;
                            return isset($identity->jobTitle->role_code)
                                && in_array($identity->jobTitle->role_code, ['manager', 'super_admin']);
                        }
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

    // ====================== ACTIONS ======================

    public function actionIndex()
    {
        $campaigns = EmailCampaign::find()->all();
        $chartData = $this->getChartData();

        return $this->render('index', [
            'campaigns' => $campaigns,
            'chartData'  => $chartData,
        ]);
    }

    public function actionCreate()
    {
        $model = new EmailCampaign();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $model->save(false); // false = skip validation again
            Yii::$app->session->setFlash('success', 'Campaign created successfully. It will be sent according to the schedule.');
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Campaign updated successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionToggleStatus($id)
    {
        $model = EmailCampaign::findOne($id);
        if ($model) {
            $model->status = $model->status === 'on' ? 'off' : 'on';
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Campaign status updated.');
        }

        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Campaign deleted.');

        return $this->redirect(['index']);
    }

    public function actionPreview($id, $contact_id = null)
    {
        $campaign = $this->findModel($id);

        $contact = $contact_id
            ? SalesContact::findOne($contact_id)
            : new SalesContact([
                'name'           => 'Sample Name',
                'email'          => 'sample@example.com',
                'company_status' => 'Sample Company',
                'phone'          => '0123456789',
                'phone1'         => '0987654321',
                'zalo'           => 'sample_zalo',
                'area'           => 'Sample Area',
                'address'        => 'Sample Address',
            ]);

        if (!$contact) {
            throw new NotFoundHttpException('Contact not found.');
        }

        $content = $this->renderPartial('@common/mail/introduce-bdsdaily', [
            'name'           => $contact->name,
            'email'          => $contact->email,
            'content'        => $campaign->content,
            'company_status' => $contact->company_status,
            'phone'          => $contact->phone,
            'phone1'         => $contact->phone1 ?? '',
            'zalo'           => $contact->zalo ?? '',
            'area'           => $contact->area ?? '',
            'address'        => $contact->address ?? '',
        ]);

        return $this->render('preview', [
            'campaign' => $campaign,
            'contact'  => $contact,
            'content'  => $content,
        ]);
    }

    public function actionLogs()
    {
        $logs = EmailLog::find()->orderBy(['sent_at' => SORT_DESC])->all();

        return $this->render('logs', ['logs' => $logs]);
    }

    // ====================== PUBLIC API FOR n8n ======================

    public function actionCheckSchedule()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $currentDay  = date('N');   // 1 = Monday ... 7 = Sunday
        $currentHour = date('H');   // 00-23

        $campaigns = EmailCampaign::find()
            ->where([
                'send_day'  => $currentDay,
                'send_hour' => $currentHour,
                'status'    => 'on',
            ])
            ->all();

        $queued = [];

        foreach ($campaigns as $campaign) {
            $count = $this->pushToQueue($campaign->id);
            if ($count > 0) {
                $queued[] = ['id' => $campaign->id, 'queued' => $count];
            }
        }

        return [
            'status'           => 'success',
            'checked_at'       => date('c'),
            'queued_campaigns' => $queued,
            'total_queued'     => array_sum(array_column($queued, 'queued')),
        ];
    }

    // ====================== PRIVATE HELPERS ======================

    /**
     * Push emails of a campaign to RabbitMQ
     * Only sends to contacts that have NEVER received ANY email from the system
     */
    private function pushToQueue(int $campaignId): int
    {
        $config = Yii::$app->params['rabbitmq'] ?? null;
        if (!$config) {
            Yii::error('RabbitMQ configuration missing.', __METHOD__);
            return 0;
        }

        $connection = null;
        $channel    = null;

        try {
            $connection = new AMQPStreamConnection(
                $config['host'],
                $config['port'],
                $config['username'],
                $config['password'],
                '/',
                false,
                'AMQPLAIN',
                null,
                'en_US',
                3.0,
                3.0,
                null,
                true // keepalive
            );

            $channel = $connection->channel();
            $channel->queue_declare('email_queue', false, true, false, false);
        } catch (\Throwable $e) {
            Yii::error('RabbitMQ connection failed: ' . $e->getMessage(), __METHOD__);
            return 0;
        }

        $campaign = EmailCampaign::findOne($campaignId);
        if (!$campaign) {
            Yii::error("Campaign ID {$campaignId} not found.", __METHOD__);
            $this->closeRabbitMQ($channel, $connection);
            return 0;
        }

        // ---------- Daily limit ----------
        $sentToday = (int) EmailLog::find()
            ->where(['campaign_id' => $campaign->id, 'status' => 'sent'])
            ->andWhere(['>=', 'sent_at', date('Y-m-d 00:00:00')])
            ->count();

        $dailyLimit      = (int) ($campaign->limit ?? 100);
        $remainingLimit  = $dailyLimit - $sentToday;

        if ($remainingLimit <= 0) {
            Yii::info("Campaign {$campaign->id} reached daily limit ({$sentToday}/{$dailyLimit})", __METHOD__);
            $this->closeRabbitMQ($channel, $connection);
            return 0;
        }

        // ---------- Get emails that have EVER been sent in the whole system ----------
        $sentEmails = EmailLog::find()
            ->select('email')
            ->where(['IS NOT', 'email', null])
            ->andWhere(['<>', 'email', ''])
            ->distinct()
            ->column();

        $query = SalesContact::find()
            ->select(['id', 'name', 'email', 'phone', 'phone1', 'company_status', 'zalo', 'area', 'address'])
            ->where(['IS NOT', 'email', null])
            ->andWhere(['<>', 'email', '']);

        if (!empty($sentEmails)) {
            $query->andWhere(['NOT IN', 'email', $sentEmails]);
        }

        $recipients = $query
            ->orderBy(new \yii\db\Expression('RAND()'))
            ->limit($remainingLimit)
            ->asArray()
            ->all();

        if (empty($recipients)) {
            Yii::info("Campaign {$campaign->id}: No new contacts left to send.", __METHOD__);
            $this->closeRabbitMQ($channel, $connection);
            return 0;
        }

        $queuedCount = 0;

        foreach ($recipients as $recipient) {
            $payload = [
                'campaign_id'     => $campaign->id,
                'name'            => $recipient['name'] ?? '',
                'recipient_email' => $recipient['email'],
                'company_status'  => $recipient['company_status'] ?? '',
                'phone'           => $recipient['phone'] ?? '',
                'phone1'          => $recipient['phone1'] ?? '',
                'zalo'            => $recipient['zalo'] ?? '',
                'area'            => $recipient['area'] ?? '',
                'address'         => $recipient['address'] ?? '',
                'subject'         => $campaign->subject,
                'content'         => $campaign->content,
            ];

            try {
                $msg = new AMQPMessage(json_encode($payload), [
                    'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
                ]);

                $channel->basic_publish($msg, '', 'email_queue');
                $queuedCount++;

                Yii::info("QUEUED → {$recipient['email']} (Campaign #{$campaign->id})", __METHOD__);
            } catch (\Throwable $e) {
                Yii::error("Failed to queue {$recipient['email']}: {$e->getMessage()}", __METHOD__);
            }
        }

        $this->closeRabbitMQ($channel, $connection);

        Yii::info("Campaign {$campaign->id} → queued {$queuedCount} brand-new emails.", __METHOD__);

        return $queuedCount;
    }

    private function closeRabbitMQ($channel, $connection): void
    {
        try {
            $channel?->close();
        } catch (\Throwable $e) {}
        try {
            $connection?->close();
        } catch (\Throwable $e) {}
    }

    /**
     * Chart data for last 7 days
     */
    protected function getChartData(): array
    {
        $sevenDaysAgo = date('Y-m-d 00:00:00', strtotime('-7 days'));

        $rows = EmailLog::find()
            ->select([
                'log_date' => 'DATE(sent_at)',
                'status',
                'cnt'      => 'COUNT(*)',
            ])
            ->where(['>=', 'sent_at', $sevenDaysAgo])
            ->groupBy(['DATE(sent_at)', 'status'])
            ->asArray()
            ->all();

        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $data[$date] = ['success' => 0, 'failure' => 0];
        }

        foreach ($rows as $row) {
            $date   = $row['log_date'];
            $status = strtolower($row['status']);
            $count  = (int)$row['cnt'];

            if ($status === 'sent' || $status === 'success') {
                $data[$date]['success'] += $count;
            } elseif ($status === 'failed' || $status === 'error') {
                $data[$date]['failure'] += $count;
            }
        }

        return [
            'labels'       => array_map(fn($d) => date('d/m', strtotime($d)), array_keys($data)),
            'successData'  => array_values(array_column($data, 'success')),
            'failureData' => array_values(array_column($data, 'failure')),
        ];
    }

    /**
     * @param int $id
     * @return EmailCampaign
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): EmailCampaign
    {
        $model = EmailCampaign::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested campaign does not exist.');
        }
        return $model;
    }
}
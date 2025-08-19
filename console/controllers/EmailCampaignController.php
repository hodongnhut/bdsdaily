<?php
namespace console\controllers;

use Yii;
use common\models\EmailLog;
use yii\console\Controller;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class EmailCampaignController extends Controller
{
    public function actionProcessQueue()
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

        $this->stdout(" [*] Waiting for messages. To exit press CTRL+C\n");

        $callback = function ($msg) {
            $data = json_decode($msg->body, true);
            $this->sendEmail($data['recipient_email'], $data['subject'], $data['content'], $data['campaign_id'], $data['name']);
            $this->stdout(" [x] Sent email to {$data['recipient_email']}\n");
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume('email_queue', '', false, false, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    private function sendEmail($email, $subject, $content, $campaignId, $name)
    {
        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->stdout("Invalid email address: $email\n");
                return Controller::EXIT_CODE_ERROR;
            }

            $result = Yii::$app->mailer->compose('@common/mail/introduce-bdsdaily', [
                'name' => $name,
                'email' => $email,
            ])
            ->setFrom(['nhuthd@bdsdaily.com' => 'BDSDaily'])
            ->setTo($email)
            ->setSubject($subject)
            ->send();

            if ($result) {
                $this->stdout("Test email sent successfully to $email\n");
                $this->stdout("Check MailHog at http://localhost:8025 to view the email.\n");
            } else {
                $this->stdout("Failed to send test email to $email\n");
            }
        } catch (\Exception $e) {
            $this->stdout("Error sending test email to $email: {$e->getMessage()}\n");
            return Controller::EXIT_CODE_ERROR;
        }
        $log = new EmailLog();
        $log->campaign_id = $campaignId;
        $log->email = $email;
        $log->status = $result ? 'sent' : 'failed';
        $log->sent_at = date('Y-m-d H:i:s');
        $log->save();
    }
}

<?php
namespace console\controllers;

use Yii;
use common\models\EmailLog;
use yii\console\Controller;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;

class EmailCampaignController extends Controller
{
    public function actionProcessQueue()
    {
        $rabbitMqConfig = Yii::$app->params['rabbitmq'];

        try {
            // Establish RabbitMQ connection
            $connection = new AMQPStreamConnection(
                $rabbitMqConfig['host'],
                $rabbitMqConfig['port'],
                $rabbitMqConfig['username'],
                $rabbitMqConfig['password']
            );
        } catch (\Exception $e) {
            $this->stdout("Failed to connect to RabbitMQ: {$e->getMessage()}\n");
            return Controller::EXIT_CODE_ERROR;
        }

        try {
            $channel = $connection->channel();
            $channel->queue_declare('email_queue', false, true, false, false);

            $this->stdout(" [*] Waiting for messages. To exit press CTRL+C\n");

            $callback = function ($msg) {
                $data = json_decode($msg->body, true);
                $this->sendEmail(
                    $data['recipient_email'],
                    $data['subject'],
                    $data['content'],
                    $data['campaign_id'],
                    $data['name']
                );
                $this->stdout(" [x] Processed email to {$data['recipient_email']}\n");
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            };

            $channel->basic_qos(null, 1, null);
            $channel->basic_consume('email_queue', '', false, false, false, false, $callback);

            // Register shutdown function to ensure resources are closed
            register_shutdown_function(function () use ($channel, $connection) {
                try {
                    $channel->close();
                    $connection->close();
                } catch (\Exception $e) {
                    $this->stdout("Error closing RabbitMQ connection: {$e->getMessage()}\n");
                }
            });

            while ($channel->is_consuming()) {
                $channel->wait();
            }
        } catch (AMQPRuntimeException $e) {
            $this->stdout("RabbitMQ error: {$e->getMessage()}\n");
            return Controller::EXIT_CODE_ERROR;
        } catch (\Exception $e) {
            $this->stdout("Unexpected error: {$e->getMessage()}\n");
            return Controller::EXIT_CODE_ERROR;
        } finally {
            // Ensure resources are closed if an error occurs
            try {
                $channel->close();
                $connection->close();
            } catch (\Exception $e) {
                $this->stdout("Error closing RabbitMQ connection: {$e->getMessage()}\n");
            }
        }

        return Controller::EXIT_CODE_NORMAL;
    }

    private function sendEmail($email, $subject, $content, $campaignId, $name)
    {
        $log = new EmailLog();
        $log->campaign_id = $campaignId;
        $log->email = $email;
        $log->sent_at = date('Y-m-d H:i:s');

        try {
            // Validate email address
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->stdout("Invalid email address: $email\n");
                $log->status = 'failed';
                if (!$log->save()) {
                    $this->stdout("❌ Failed to save EmailLog for {$email}: " . print_r($log->getErrors(), true) . "\n");
                } else {
                    $this->stdout("✅ Logged email status for {$email}\n");
                }
                return Controller::EXIT_CODE_ERROR;
            }

            // Send email using Yii2 mailer
            $result = Yii::$app->mailer->compose('@common/mail/introduce-bdsdaily', [
                'name' => $name,
                'email' => $email,
            ])
                ->setFrom(['nhuthd@bdsdaily.com' => 'BDSDaily'])
                ->setTo($email)
                ->setSubject($subject)
                ->send();

            // Log email status
            $log->status = $result ? 'sent' : 'failed';
            if ($result) {
                $this->stdout("Test email sent successfully to $email\n");
                $this->stdout("Check MailHog at http://localhost:8025 to view the email.\n");
            } else {
                $this->stdout("Failed to send test email to $email\n");
            }

            if (!$log->save()) {
                $this->stdout("❌ Failed to save EmailLog for {$email}: " . print_r($log->getErrors(), true) . "\n");
            } else {
                $this->stdout("✅ Logged email status for {$email}\n");
            }

            return $result ? Controller::EXIT_CODE_NORMAL : Controller::EXIT_CODE_ERROR;
        } catch (\Exception $e) {
            $this->stdout("Error sending email to $email: {$e->getMessage()}\n");
            $log->status = 'failed';
            if (!$log->save()) {
                $this->stdout("❌ Failed to save EmailLog for {$email}: " . print_r($log->getErrors(), true) . "\n");
            } else {
                $this->stdout("✅ Logged email status for {$email}\n");
            }
            return Controller::EXIT_CODE_ERROR;
        }
    }

    public function actionTestMail($to = 'hodongnhut@gmail.com', $from = 'bdsdaily247@gmail.com')
    {
        $log = new EmailLog();
        $log->email = $to;
        $log->sent_at = date('Y-m-d H:i:s');

        try {
            $result = Yii::$app->mailer->compose()
                ->setFrom($from)
                ->setTo($to)
                ->setSubject('Test Gmail SMTP')
                ->setTextBody('Hello, đây là mail test từ Yii2 Gmail SMTP!')
                ->send();

            $log->status = $result ? 'sent' : 'failed';
            if ($result) {
                $this->stdout("Đã gửi mail đến $to!\n");
                $this->stdout("Check MailHog at http://localhost:8025 to view the email.\n");
            } else {
                $this->stdout("Gửi mail thất bại đến $to!\n");
            }

            if (!$log->save()) {
                $this->stdout("❌ Failed to save EmailLog for {$to}: " . print_r($log->getErrors(), true) . "\n");
            } else {
                $this->stdout("✅ Logged email status for {$to}\n");
            }

            return $result ? Controller::EXIT_CODE_NORMAL : Controller::EXIT_CODE_ERROR;
        } catch (\Exception $e) {
            $this->stdout("Error sending test email to $to: {$e->getMessage()}\n");
            $log->status = 'failed';
            if (!$log->save()) {
                $this->stdout("❌ Failed to save EmailLog for {$to}: " . print_r($log->getErrors(), true) . "\n");
            } else {
                $this->stdout("✅ Logged email status for {$to}\n");
            }
            return Controller::EXIT_CODE_ERROR;
        }
    }
}
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

            $result = Yii::$app->mailer->compose('@common/mail/introduce-bdsdaily', [
                'name' => $name,
                'email' => $email,
            ])
                ->setFrom(from: ['nhuthd@bdsdaily.com' => 'BDSDaily'])
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

    public function actionTestMail($to = 'hodongnhut@gmail.com', $from = 'nhuthd@bdsdaily.com')
    {
        $this->stdout("=== RESEND + YII2 SYMFONY MAILER TEST (2025) ===\n");
        $this->stdout("To:   $to\n");
        $this->stdout("From: $from\n\n");

        try {
            // 1. Check mailer exists
            if (!Yii::$app->has('mailer')) {
                $this->stdout("ERROR: Component 'mailer' not configured!\n");
                return Controller::EXIT_CODE_ERROR;
            }

            $mailer = Yii::$app->mailer;

            // 2. Show real DSN being used (this is the most important line!)
            $transport = $mailer->getTransport();
            if (method_exists($transport, 'toString')) {
                $this->stdout("DSN being used: " . $transport->toString() . "\n\n");
            } else {
                $this->stdout("Transport: " . get_class($transport) . "\n\n");
            }

            // 3. Build message
            $message = $mailer->compose()
                ->setFrom($from)
                ->setTo($to)
                ->setSubject('Test Resend – ' . date('Y-m-d H:i:s'))
                ->setTextBody('Hello from Yii2 + Resend! Time: ' . date('c') . "\n\nIf you see this email → everything works!");

            // 4. Send with full error details
            $this->stdout("Sending email...\n");
            $sent = $message->send();

            if ($sent) {
                $this->stdout("EMAIL SENT SUCCESSFULLY!\n");
                $this->stdout("Check inbox/spam at: $to\n");
                $this->stdout("Also check: https://resend.com/emails\n");
            } else {
                $this->stdout("SEND RETURNED FALSE – usually means:\n");
                $this->stdout("   • Domain bdsdaily.com not verified in Resend\n");
                $this->stdout("   • From address not allowed\n");
                $this->stdout("   • API key has no permission\n");
            }

            return $sent ? Controller::EXIT_CODE_NORMAL : Controller::EXIT_CODE_ERROR;

        } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
            $this->stdout("TRANSPORT ERROR (this is the real problem!):\n");
            $this->stdout($e->getMessage() . "\n\n");

            // Most common messages you'll see:
            if (str_contains($e->getMessage(), 'authentication failed')) {
                $this->stdout("FIX: Wrong API key! Use your real re_xxx key as BOTH username & password\n");
            }
            if (str_contains($e->getMessage(), 'Connection refused')) {
                $this->stdout("FIX: Port blocked or wrong port. Use 587 + TLS\n");
            }
            if (str_contains($e->getMessage(), '535')) {
                $this->stdout("FIX: Authentication failed – 99% wrong API key\n");
            }

            return Controller::EXIT_CODE_ERROR;

        } catch (\Exception $e) {
            $this->stdout("UNEXPECTED ERROR: " . $e->getMessage() . "\n");
            $this->stdout("Class: " . get_class($e) . "\n");
            $this->stdout("Trace:\n" . $e->getTraceAsString() . "\n");
            return Controller::EXIT_CODE_ERROR;
        }
    }
}
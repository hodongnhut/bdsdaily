<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use common\models\EmailLog;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use PhpAmqpLib\Exception\AMQPRuntimeException;

class EmailCampaignController extends Controller
{
    private $connection;
    private $channel;

    /**
     * Consumer: Lắng nghe queue và gửi email
     * Chạy bằng lệnh: ./yii email-campaign/process-queue
     */
    public function actionProcessQueue()
    {
        $this->stdout("Starting Email Queue Consumer...\n");
        $this->stdout("Press CTRL+C to stop\n\n");

        while (true) {
            try {
                $this->initRabbitMQ();

                $this->channel->basic_qos(0, 1, false); // Chỉ xử lý 1 message/lần
                $this->channel->basic_consume(
                    'email_queue',
                    '',
                    false,
                    false, // no_ack = false → phải ack thủ công
                    false,
                    false,
                    [$this, 'processMessage']
                );

                $this->stdout("Connected to RabbitMQ. Waiting for messages...\n");

                // Vòng lặp chính – tự động reconnect nếu mất kết nối
                while ($this->channel->is_consuming()) {
                    $this->channel->wait(null, false, 30); // timeout 30s
                }

            } catch (AMQPTimeoutException $e) {
                $this->stdout("Timeout – checking queue. Reconnecting in 5s...\n");
            } catch (\ErrorException | AMQPRuntimeException $e) {
                $this->stdout("Connection lost: " . $e->getMessage() . "\n");
                $this->stdout("Reconnecting in 5 seconds...\n");
            } catch (\Throwable $e) {
                $this->stdout("Unexpected error: " . $e->getMessage() . "\n");
                $this->stdout("Reconnecting in 10 seconds...\n");
            } finally {
                $this->closeConnection();
                sleep(5); // Đợi trước khi reconnect
            }
        }

        return ExitCode::OK;
    }

    /**
     * Callback xử lý từng message
     */
    public function processMessage(AMQPMessage $msg)
    {
        $body = $msg->getBody();
        $data = json_decode($body, true);

        if (!$data || !isset($data['recipient_email'])) {
            $this->stdout("Invalid message format. Nacking...\n");
            $msg->nack(true); // requeue = true
            return;
        }

        $email = $data['recipient_email'];
        $this->stdout("Processing: {$email} | Campaign #{$data['campaign_id']}\n");

        $success = $this->sendAndLogEmail($data);

        if ($success) {
            $msg->ack();
            $this->stdout("Sent & ACK: {$email}\n");
        } else {
            // Không ack → message sẽ được đưa lại queue sau (tự động retry)
            $this->stdout("Failed → Will retry later: {$email}\n");
            $msg->nack(false); // không requeue ngay để tránh spam
        }
    }

    /**
     * Gửi email + ghi log EmailLog
     */
    private function sendAndLogEmail(array $data): bool
    {
        $log = new EmailLog();
        $log->campaign_id = $data['campaign_id'] ?? null;
        $log->email = $data['recipient_email'];
        $log->sent_at = date('Y-m-d H:i:s');

        try {
            // Validate email
            if (!filter_var($log->email, FILTER_VALIDATE_EMAIL)) {
                $log->status = 'failed';
                $log->note = 'Invalid email format';
                $log->save(false);
                return false;
            }

            // Render nội dung với đầy đủ biến
            $htmlBody = $this->renderEmailTemplate($data);

            $sent = Yii::$app->mailer
                ->compose()
                ->setFrom(['nhuthd@bdsdaily.com' => 'BDSDaily'])
                ->setTo($log->email)
                ->setSubject($data['subject'] ?? 'Tin tức từ BDSDaily')
                ->setHtmlBody($htmlBody)
                ->send();

            $log->status = $sent ? 'sent' : 'failed';
            if (!$sent) {
                $log->note = Yii::$app->mailer->getLastError() ?: 'Unknown mailer error';
            }

            if (!$log->save()) {
                $this->stdout("Failed to save log: " . json_encode($log->getErrors()) . "\n");
            }

            return $sent;

        } catch (\Throwable $e) {
            $this->stdout("Exception: " . $e->getMessage() . "\n");
            $log->status = 'failed';
            $log->note = substr($e->getMessage(), 0, 255);
            $log->save(false);
            return false;
        }
    }

    /**
     * Render email template với đầy đủ dữ liệu từ payload
     */
    private function renderEmailTemplate(array $data): string
    {
        return $this->renderPartial('@common/mail/introduce-bdsdaily', [
            'name'           => $data['name'] ?? 'Khách hàng',
            '',
            'email'          => $data['recipient_email'],
            'content'        => $data['content'] ?? '',
            'company_status' => $data['company_status'] ?? '',
            'phone'          => $data['phone'] ?? '',
            'phone1'         => $data['phone1'] ?? '',
            'zalo'           => $data['zalo'] ?? '',
            'area'           => $data['area'] ?? '',
            'address'        => $data['address'] ?? '',
        ]);
    }

    /**
     * Khởi tạo kết nối RabbitMQ
     */
    private function initRabbitMQ()
    {
        $config = Yii::$app->params['rabbitmq'];

        $this->connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['username'],
            $config['password'],
            '/',
            false,
            'AMQPLAIN',
            null,
            'en_US',
            10.0,  // connection timeout
            30.0,  // read timeout
            null,
            true,  // keepalive
            30     // heartbeat
        );

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('email_queue', false, true, false, false);
    }

    /**
     * Đóng kết nối an toàn
     */
    private function closeConnection(): void
    {
        try {
            $this->channel?->close();
        } catch (\Throwable $e) {}
        try {
            $this->connection?->close();
        } catch (\Throwable $e) {}
    }

    // Giữ lại action test mail (cực kỳ hữu ích để debug Resend/SMTP)
    public function actionTestMail($to = 'hodongnhut@gmail.com')
    {
        // ... giữ nguyên như cũ của bạn, chỉ thêm 1 dòng nhỏ:
        $this->stdout("DSN: " . Yii::$app->mailer->getTransport()->toString() . "\n");
        // ... phần còn lại giống hệt bạn viết
    }
}
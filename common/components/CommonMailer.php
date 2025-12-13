<?php

namespace common\components;

use yii\symfonymailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mailer\Transport\FailoverTransport;
use common\models\MailerConfig;
use Exception;

class CommonMailer extends Mailer
{
    public function init()
    {
        parent::init();

        try {
            $this->setTransport($this->createFallbackTransport());
        } catch (\Throwable $e) {
            \Yii::error('Không thể khởi tạo mailer fallback: ' . $e->getMessage());
            // Fallback cuối cùng: dùng transport null (không gửi được nhưng không crash app)
            $this->setTransport(Transport::newNullTransport());
        }
    }

    /**
     * Tạo FailoverTransport từ các config trong DB
     */
    protected function createFallbackTransport(): TransportInterface
    {
        $configs = MailerConfig::getActiveConfigs();

        if (empty($configs)) {
            throw new \yii\base\Exception('Không có mailer config nào được bật (is_active = 1)');
        }

        $transports = [];

        foreach ($configs as $config) {
            try {
                $transportConfig = $config->getTransportConfig(); // trả về mảng ['dsn' => '...'] hoặc ['scheme'=>..., 'host'=>...]

                // Ưu tiên dùng DSN string nếu có
                if (!empty($transportConfig['dsn'])) {
                    $dsn = $transportConfig['dsn'];
                } else {
                    // Tự build DSN từ mảng
                    $dsn = Transport::fromDsnArray($transportConfig);
                }

                $transport = Transport::fromDsn($dsn);
                $transports[] = $transport;

                \Yii::info("Đã thêm mailer: {$dsn}");

            } catch (\Throwable $e) {
                \Yii::error("LỖI config mailer ID {$config->id}: " . $e->getMessage());
                // Bỏ qua config lỗi, tiếp tục với config khác
            }
        }

        if (empty($transports)) {
            throw new \yii\base\Exception('Tất cả mailer config đều lỗi hoặc không hợp lệ!');
        }

        // Nếu chỉ có 1 → trả về luôn
        if (count($transports) === 1) {
            return $transports[0];
        }

        // Nhiều hơn 1 → dùng Failover (gửi cái đầu tiên sống)
        return new FailoverTransport($transports);
    }

    /**
     * Override send() để log rõ lỗi
     */
    public function send($message): bool
    {
        try {
            $result = parent::send($message);
            if ($result) {
                \Yii::info('Gửi email thành công qua CommonMailer');
            }
            return $result;
        } catch (\Throwable $e) {
            \Yii::error('GỬI EMAIL THẤT BẠI QUA COMMONMAILER: ' . $e->getMessage());
            \Yii::error('Trace: ' . $e->getTraceAsString());

            // Optional: thử gửi qua transport null để không crash
            return false;
        }
    }
}
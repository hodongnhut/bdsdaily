<?php

namespace common\components;

use common\models\MailerConfig;
use yii\symfonymailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Exception;

class CommonMailer extends Mailer
{
    public function init()
    {
        parent::init();
        $this->setTransport($this->createFallbackTransport());
    }

    protected function createFallbackTransport()
    {
        $configs = MailerConfig::getActiveConfigs();

        if (empty($configs)) {
            throw new \yii\base\Exception('Không có cấu hình mailer nào được kích hoạt!');
        }

        $transports = [];
        foreach ($configs as $config) {
            try {
                $transportConfig = $config->getTransportConfig();
                $dsn = $transportConfig['dsn'] ?? Transport::fromDsnArray($transportConfig);
                $transports[] = Transport::fromDsn($dsn);
            } catch (Exception $e) {
                \Yii::error("Mailer config ID {$config->id} lỗi: " . $e->getMessage());
            }
        }

        if (empty($transports)) {
            throw new \yii\base\Exception('Tất cả mailer config đều lỗi!');
        }

        return Transport::fromDsns(array_map(fn($t) => $t->toString(), $transports));
    }

    public function send($message): bool
    {
        try {
            return parent::send($message);
        } catch (Exception $e) {
            \Yii::error('Gửi mail thất bại hoàn toàn: ' . $e->getMessage());
            return false;
        }
    }
}
<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property $name
 * @property $driver
 * @property $dsn
 * @property $host
 * @property $username
 * @property $password
 * @property $port
 * @property $encryption
 * @property $is_active
 * @property $priority
 * @property $created_at
 * @property $updated_at
 */
class MailerConfig extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%mailer_config}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['name', 'driver'], 'required'],
            [['dsn', 'host', 'username', 'password', 'encryption'], 'string'],
            [['port', 'priority', 'is_active'], 'integer'],
            [['is_active'], 'default', 'value' => 1],
            [['priority'], 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Tên cấu hình',
            'driver' => 'Loại',
            'dsn' => 'DSN (nếu chọn DSN)',
            'host' => 'Host',
            'username' => 'Username/Email',
            'password' => 'Password/API Key',
            'port' => 'Port',
            'encryption' => 'Encryption',
            'is_active' => 'Kích hoạt',
            'priority' => 'Độ ưu tiên (cao hơn = dùng trước)',
        ];
    }

    public function getTransportConfig()
    {
        if ($this->driver === 'dsn' && $this->dsn) {
            return ['dsn' => $this->dsn];
        }

        return [
            'scheme' => 'smtp',
            'host' => $this->host,
            'username' => $this->username,
            'password' => $this->password,
            'port' => $this->port,
            'encryption' => $this->encryption ?: null,
        ];
    }

    // Lấy danh sách config active, sắp xếp priority giảm dần
    public static function getActiveConfigs()
    {
        return self::find()
            ->where(['is_active' => 1])
            ->orderBy(['priority' => SORT_DESC])
            ->all();
    }
}
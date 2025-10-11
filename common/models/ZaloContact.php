<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zalo_contact".
 *
 * @property int $id
 * @property string|null $status
 * @property string|null $uuid
 * @property string|null $threadid
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $zalo
 * @property string|null $area
 * @property string|null $address
 * @property string $created_at
 * @property string|null $updated_at
 */
class ZaloContact extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_SENDING = 0; // 'Sending';
    const STATUS_SUCCESS = 1; // 'Success';
    const STATUS_FAILED = 2; // 'Failed';
    const STATUS_NOTYET = 3; //'NotYet';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zalo_contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'uuid', 'threadid', 'email', 'phone', 'zalo', 'area', 'address', 'updated_at'], 'default', 'value' => null],
            [['status', 'area', 'address'], 'string'],
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid', 'threadid', 'phone', 'zalo'], 'string', 'max' => 50],
            [['name', 'email'], 'string', 'max' => 255],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'uuid' => 'Uuid',
            'threadid' => 'Threadid',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'zalo' => 'Zalo',
            'area' => 'Area',
            'address' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_SENDING => 'Sending',
            self::STATUS_SUCCESS => 'Success',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_NOTYET => 'NotYet',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusSending()
    {
        return $this->status === self::STATUS_SENDING;
    }

    public function setStatusToSending()
    {
        $this->status = self::STATUS_SENDING;
    }

    /**
     * @return bool
     */
    public function isStatusSuccess()
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    public function setStatusToSuccess()
    {
        $this->status = self::STATUS_SUCCESS;
    }

    /**
     * @return bool
     */
    public function isStatusFailed()
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function setStatusToFailed()
    {
        $this->status = self::STATUS_FAILED;
    }

    /**
     * @return bool
     */
    public function isStatusNotyet()
    {
        return $this->status === self::STATUS_NOTYET;
    }

    public function setStatusToNotyet()
    {
        $this->status = self::STATUS_NOTYET;
    }
}

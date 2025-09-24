<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "email_campaign".
 *
 * @property int $id
 * @property string $subject
 * @property string $content
 * @property int $send_day
 * @property int $send_hour
 * @property string $created_at
 */
class EmailCampaign extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'email_campaign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'content', 'send_day', 'send_hour'], 'required'],
            [['content'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['send_day'], 'integer', 'min' => 1, 'max' => 7], // 1: Monday, 7: Sunday
            [['send_hour'], 'integer', 'min' => 0, 'max' => 23], // 0-23 hours
            [['status'], 'in', 'range' => ['on', 'off']], // Status: on or off
            [['limit'], 'integer'], // 0-23 hours
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Tiêu đề',
            'content' => 'Nội Dung',
            'send_day' => 'Ngày Gửi',
            'send_hour' => 'Giờ Gửi',
            'status' => 'Trạng Thái',
            'created_at' => 'Ngày tạo',
            'limit' => 'Số Email gửi 1 ngày',
        ];
    }

}

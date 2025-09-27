<?php
namespace common\models;

use yii\db\ActiveRecord;

class EmailLog extends ActiveRecord
{
    public static function tableName()
    {
        return 'email_log';
    }

    public function rules()
    {
        return [
            [['campaign_id', 'email', 'status'], 'required'],
            [['campaign_id'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => ['sent', 'failed', 'pending']],
            [['sent_at'], 'safe'],
        ];
    }

    /**
     * Gets query for [[EmailCampaign]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(EmailCampaign::class, ['id' => 'campaign_id']);
    }
}
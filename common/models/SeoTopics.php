<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "seo_topics".
 *
 * @property int $id
 * @property string $title
 * @property int|null $status
 * @property string $created_at
 * @property string $updated_at
 */
class SeoTopics extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo_topics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 0],
            [['title'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Chủ Đề',
            'status' => 'Trạng Thái',
            'created_at' => 'Ngày Tạo',
            'updated_at' => 'Updated At',
        ];
    }

}

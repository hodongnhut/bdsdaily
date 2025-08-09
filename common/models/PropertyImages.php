<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class PropertyImages extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_external'], 'default', 'value' => 0],
            [['property_id', 'image_path'], 'required'],
            [['property_id', 'sort_order', 'created_at', 'updated_at', 'status_external'], 'integer'],
            [['is_main', 'image_type'], 'boolean'],
            [['image_path'], 'string', 'max' => 255],
            [['image_type'], 'default', 'value' => 0],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::class, 'targetAttribute' => ['property_id' => 'property_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image_id' => 'Image ID',
            'property_id' => 'Property ID',
            'image_path' => 'Image Path',
            'image_type' => 'Image Type',
            'is_main' => 'Is Main',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status_external' => 'Status External',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Properties::class, ['property_id' => 'property_id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = time();
            $this->updated_at = time();
        } else {
            $this->updated_at = time();
        }
        return parent::beforeSave($insert);
    }

    /**
     * Get the main image for a property
     * @param int $propertyId
     * @return static|null
     */
    public static function getMainImage($propertyId)
    {
        return static::find()
            ->where(condition: ['property_id' => $propertyId, 'image_type' => 1])
            ->orderBy(['sort_order' => SORT_ASC])
            ->one();
    }
}
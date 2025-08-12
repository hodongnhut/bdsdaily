<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sales_contact".
 *
 * @property int $id
 * @property string $name
 * @property string|null $company_status
 * @property string $email
 * @property string|null $phone
 * @property string|null $zalo
 * @property string|null $area
 * @property string|null $address
 * @property string $created_at
 * @property string|null $updated_at
 */
class SalesContact extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_status', 'phone', 'zalo', 'area', 'address', 'updated_at'], 'default', 'value' => null],
            [['name', 'email'], 'required'],
            [['address'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'company_status', 'email', 'area'], 'string', 'max' => 255],
            [['phone', 'zalo'], 'string', 'max' => 50],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'company_status' => 'Company Status',
            'email' => 'Email',
            'phone' => 'Phone',
            'zalo' => 'Zalo',
            'area' => 'Area',
            'address' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}

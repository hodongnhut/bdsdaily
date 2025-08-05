<?php

namespace common\models;



use Yii;
use yii\httpclient\Client;
use yii\helpers\Json;
// use common\models\AssetTypes;

/**
 * This is the model class for table "properties".
 *
 * @property int $property_id Unique identifier for the property
 * @property int $user_id Foreign key to the user table (who manages/created this property)
 * @property string|null $title General title for the property listing
 * @property int|null $property_type_id [FK] Loại sản phẩm
 * @property int|null $has_vat_invoice Indicates if the property comes with a VAT invoice (0=No, 1=Yes)
 * @property string|null $house_number Số nhà
 * @property string|null $street_name Đưởng phố
 * @property string|null $ward_commune phường
 * @property string|null $district_county tỉnh
 * @property string|null $city thành phố
 * @property int|null $location_type_id [FK] Vị trí (Vị trí BĐS)
 * @property string|null $compound_name Name of the compound, if applicable
 * @property float|null $final_price Giá chốt thực tế sau khi thương lượng
 * @property float|null $area_width Ngang (Diện tích đất)
 * @property float|null $area_length Dài (Diện tích đất)
 * @property float|null $area_total DT Công Nhận (Diện tích đất)
 * @property float|null $planned_width Ngang (Diện tích quy hoạch)
 * @property float|null $planned_length Dài (Diện tích quy hoạch)
 * @property float|null $planned_construction_area Diện tích xây dựng (Diện tích quy hoạch)
 * @property string|null $usable_area DT sử dụng (Thông tin khác)
 * @property string|null $direction Hướng (Thông tin khác)
 * @property string|null $land_type_id Loại đất (Thông tin khác)
 * @property int|null $num_toilets Số WC (Thông tin khác)
 * @property int|null $num_bedrooms Số phòng ngủ (Thông tin khác)
 * @property int|null $num_basements Số Tầng hầm (Thông tin khác)
 * @property int|null $asset_type_id [FK] Loại tài sản (Loại tài sản)
 * @property string|null $description Detailed description of the property
 * @property int|null $has_deposit Indicates if a deposit has been placed (0=No, 1=Yes)
 * @property int|null $transaction_status_id [FK] transaction_statuses
 * @property string|null $transaction_description Additional description for transaction status
 * @property int|null $has_rental_contract Hợp đồng thuê
 * @property int|null $is_active General listing status (0=Inactive, 1=Active)
 * @property int $created_at Thời gian tạo
 * @property int $updated_at Thời gian cập nhật
 * @property string|null $external_id ID bên ngoài (ID Crawl)
 * @property int|null $num_floors Số Tầng Hầm (Thông tin khác)
 * @property string|null $plot_number Số thửa (Giá)
 * @property string|null $sheet_number Số tờ (Giá)
 * @property string|null $lot_number Số lô (Giá)
 * @property int|null $commission_types_id [FK] Loại hoa hồng (commission_prices)
 * @property int|null $commission_prices_id [FK] (commission_prices)
 * @property float|null $area_back_side Mặt hậu (Diện tích)
 * @property float|null $wide_road Đường rộng (Thông tin khác)
 * @property float|null $planned_back_side Mặt hậu (Diện tích quy hoạch)
 * @property int|null $property_images_id [FK] Image (property_images)
 * @property string|null $new_district [FK] Quân Huyện MỚi (new_district)
 *
 * @property LocationTypes $locationType
 * @property PropertyTypes $propertyType
 * @property User $user
 */
class Properties extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'properties';
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'updateChart']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'callWebhookAfterUpdate']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'logPropertyUpdate']);
    }

    public function logPropertyUpdate($event)
    {
        $model = $event->sender;
        if (empty($event->changedAttributes)) {
            Yii::warning('No changes detected for property ID ' . $model->property_id, 'property_update_log');
            return;
        }

        $changedFields = [];
        foreach ($event->changedAttributes as $field => $oldValue) {
            $newValue = $this->attributes[$field] ?? null;
            $oldValueStr = (string)($oldValue ?? '');
            $newValueStr = (string)($newValue ?? '');
            if ($oldValueStr !== $newValueStr) {
                $changedFields[$field] = [
                    'old' => $oldValue,
                    'new' => $newValue
                ];
            }
        }

        if (empty($changedFields)) {
            Yii::warning('No actual changes detected for property ID ' . $model->property_id, 'property_update_log');
            return;
        }
        try {
            $log = new PropertyUpdateLog();
            $log->property_id = $model->property_id;
            $log->data = $model->property_id;
            $log->rendered_html_content = Json::encode(\common\helpers\HtmlLogHelper::renderHtmlLog($event));
            $log->created_at = time();
            $log->created_by = Yii::$app->user->id ?? null;
            if (!$log->save(false)) {
                Yii::error('Failed to save property update log: ' . json_encode($log->errors), 'property_update_log');
            }
        } catch (\Throwable $th) {
            Yii::error($th->getMessage());
        }
    }
    public function updateChart($event) {
        UserActivities::logActivity(Yii::$app->user->id, 'add_new');
        return;
    }



    public function callWebhookAfterUpdate($event)
    {
        UserActivities::logActivity(Yii::$app->user->id, 'update_property');

        $model = $event->sender;

        if (empty($model->area_total) || empty($model->area_length) || 
            empty($model->area_width) || empty($model->price)) {
            Yii::warning('Webhook skipped: Missing required fields for property ID ' . $model->property_id, 'webhook');
            return;
        }

        $parts = array_map('trim', explode(',', $model->title));
        if (count($parts) >= 4) {
            $street = $parts[0];

            $ward = $parts[1];
            if (!preg_match('/^(phường|xã)/i', $ward)) {
                $ward = 'Phường ' . $ward;
            }

            $district = $parts[2];
            if (!preg_match('/^(quận|huyện|thị xã|tp)/i', $district)) {
                $district = 'Quận ' . $district;
            }

            $city = $parts[3];
            $fullAddress = $street . ', ' . $ward . ', ' . $district . ', ' . $city;
        } else {
            $fullAddress = $model->title;
        }

        $price = 'Giá: ' . $this->formatPriceUnit($model->price);
        $areaTotal = 'Diện Tích: '. $this->formatNumber($model->area_total) . 'm2 ('. $this->formatNumber($model->area_width) .'m × '. $this->formatNumber($model->area_length) .'m)';

        $message = $fullAddress . "\n" . $areaTotal . "\n" . $price;
        
        $imageDomain = Yii::$app->params['imageDomain'] ?? 'https://app.bdsdaily.com';
        $images = [];

        if (count($model->propertyImages) > 0) {
            foreach ($model->propertyImages as $image) {
                $fullUrl = rtrim($imageDomain, '/') . '/' . ltrim($image->image_path, '/');
                $images[] = ['image' => $fullUrl];
            }
        }
        
        $payload = [
            'event_type' => 'property_updated',
            'timestamp' => time(),
            'message' => $message,
            'images' =>  $images
        ];

        try {
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('https://n8n.kinglandgroup.vn/webhook/kinglands')
                ->addHeaders(['Content-Type' => 'application/json'])
                ->setContent(json_encode($payload))
                ->send();

            if (!$response->isOk) {
                Yii::error('Webhook for new property failed: ' . $response->getContent(), 'webhook');
            }
        } catch (\Exception $e) {
            Yii::error('Exception during webhook call: ' . $e->getMessage(), 'webhook');
        }
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    public  function formatNumber($number) {
        if ($number === null) {
            return null;
        }
        if ($number == (int)$number) {
            return (int)$number;
        }
        
        return (float)$number;
    }

    public  function formatPriceUnit($number) {
        if (!is_numeric($number) || $number <= 0) {
            return 'Thỏa thuận';
        }
    
        $billion = 1000000000;
        $million = 1000000;
    
        if ($number >= $billion) {
            $result = $number / $billion;
            $formatted_result = rtrim(rtrim(number_format($result, 2, '.', ''), '0'), '.');
            return $formatted_result . ' Tỷ';
        }
    
        if ($number >= $million) {
            $result = $number / $million;
            $formatted_result = round($result);
            return $formatted_result . ' Triệu';
        }
        
        return number_format($number) . ' VNĐ';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'property_type_id', 'listing_types_id', 'price_unit', 'currency_id', 'price', 'final_price','house_number', 'street_name', 'ward_commune', 'district_county', 'location_type_id', 'compound_name', 'area_width', 'area_length', 'area_total', 'planned_width', 'planned_length', 'planned_construction_area', 'usable_area', 'direction_id', 'land_type_id', 'num_toilets', 'num_bedrooms', 'num_basements', 'asset_type_id', 'description', 'has_deposit', 'transaction_status_id', 'transaction_description', 'external_id', 'num_floors', 'plot_number', 'sheet_number', 'lot_number', 'commission_types_id', 'commission_prices_id', 'area_back_side', 'wide_road', 'planned_back_side', 'property_images_id', 'region', 'new_district'], 'default', 'value' => null],
            [['is_active'], 'default', 'value' => 1, 'message' => 'Trạng thái hoạt động không hợp lệ'],
            [['has_rental_contract'], 'default', 'value' => 0, 'message' => 'Hợp đồng thuê không hợp lệ'],
            [['city'], 'default', 'value' => 'Hồ Chí Minh'],

            // Các trường bắt buộc
            [[
                'user_id','location_type_id', 'price', 'area_width', 'area_total',
                'area_length', 'street_name', 'property_type_id', 'asset_type_id'
            ], 'required', 'message' => '{attribute} không được để trống'],

            // Kiểm tra kiểu dữ liệu số nguyên
            [['user_id', 'property_type_id', 'listing_types_id', 'currency_id', 'has_vat_invoice', 'location_type_id', 'direction_id', 'num_toilets', 'num_bedrooms', 'num_basements', 'asset_type_id', 'has_deposit', 'transaction_status_id', 'has_rental_contract', 'is_active', 'num_floors', 'commission_types_id', 'commission_prices_id', 'property_images_id', 'land_type_id'], 'integer', 'message' => '{attribute} phải là số nguyên'],

            // Kiểm tra kiểu số thực
            [['price','final_price', 'area_width', 'area_length', 'area_total', 'planned_width', 'planned_length', 'planned_construction_area', 'area_back_side', 'wide_road', 'planned_back_side'], 'number', 'message' => '{attribute} phải là số'],

            // Kiểm tra kiểu chuỗi và độ dài tối đa
            [['description', 'transaction_description'], 'string', 'message' => '{attribute} phải là chuỗi ký tự'],
            [['title'], 'string', 'max' => 500, 'tooLong' => '{attribute} không được vượt quá 500 ký tự'],
            [['price_unit', 'house_number', 'plot_number', 'sheet_number', 'lot_number'], 'string', 'max' => 50, 'tooLong' => '{attribute} không được vượt quá 50 ký tự'],
            [['street_name', 'compound_name', 'external_id', 'region'], 'string', 'max' => 255, 'tooLong' => '{attribute} không được vượt quá 255 ký tự'],
            [['ward_commune', 'district_county', 'city'], 'string', 'max' => 100, 'tooLong' => '{attribute} không được vượt quá 100 ký tự'],

            // Kiểm tra khóa ngoại
            [['asset_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssetTypes::class, 'targetAttribute' => ['asset_type_id' => 'asset_type_id'], 'message' => 'Loại tài sản không hợp lệ'],
            [['location_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LocationTypes::class, 'targetAttribute' => ['location_type_id' => 'location_type_id'], 'message' => 'Loại vị trí không hợp lệ'],
            [['transaction_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransactionStatuses::class, 'targetAttribute' => ['transaction_status_id' => 'transaction_status_id'], 'message' => 'Trạng thái giao dịch không hợp lệ'],
            [['property_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyTypes::class, 'targetAttribute' => ['property_type_id' => 'property_type_id'], 'message' => 'Loại bất động sản không hợp lệ'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id'], 'message' => 'Người dùng không hợp lệ'],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Directions::class, 'targetAttribute' => ['direction_id' => 'id'], 'message' => 'Hướng không hợp lệ'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::class, 'targetAttribute' => ['currency_id' => 'id'], 'message' => 'Loại tiền tệ không hợp lệ'],

            // Kiểm tra kiểu ngày giờ
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'property_id' => 'ID Bất động sản',
            'user_id' => 'ID Người dùng',
            'title' => 'Tiêu đề',
            'property_type_id' => 'Loại bất động sản',
            'listing_types_id' => 'Loại giao dịch',
            'price_unit' => 'Đơn vị giá',
            'currency_id' => 'Loại tiền tệ',
            'price' => 'Giá',
            'final_price' => 'Giá chốt',
            'has_vat_invoice' => 'Có hóa đơn VAT',
            'house_number' => 'Số nhà',
            'street_name' => 'Tên đường',
            'ward_commune' => 'Phường/Xã',
            'district_county' => 'Quận/Huyện',
            'city' => 'Thành phố',
            'location_type_id' => 'Vị Trí BĐS',
            'compound_name' => 'Tên khu đô thị',
            'area_width' => 'Chiều ngang',
            'area_length' => 'Chiều dài',
            'area_total' => 'Diện tích tổng',
            'planned_width' => 'Chiều ngang quy hoạch',
            'planned_length' => 'Chiều dài quy hoạch',
            'planned_construction_area' => 'Diện tích xây dựng quy hoạch',
            'usable_area' => 'Diện tích sử dụng',
            'direction_id' => 'Hướng',
            'land_type_id' => 'Loại đất',
            'num_toilets' => 'Số nhà vệ sinh',
            'num_bedrooms' => 'Số phòng ngủ',
            'num_basements' => 'Số tầng hầm',
            'asset_type_id' => 'Loại tài sản',
            'description' => 'Mô tả',
            'has_deposit' => 'Có đặt cọc',
            'transaction_status_id' => 'Trạng thái giao dịch',
            'transaction_description' => 'Mô tả giao dịch',
            'has_rental_contract' => 'Hợp đồng thuê',
            'is_active' => 'Trạng thái hoạt động',
            'created_at' => 'Thời gian tạo',
            'updated_at' => 'Thời gian cập nhật',
            'external_id' => 'ID bên ngoài',
            'num_floors' => 'Số tầng',
            'plot_number' => 'Số thửa',
            'sheet_number' => 'Số tờ',
            'lot_number' => 'Số lô',
            'commission_types_id' => 'Loại hoa hồng',
            'commission_prices_id' => 'Giá hoa hồng',
            'area_back_side' => 'Mặt hậu',
            'wide_road' => 'Độ rộng đường',
            'planned_back_side' => 'Mặt hậu quy hoạch',
            'property_images_id' => 'ID hình ảnh bất động sản',
            'region' => 'Khu vực',
        ];
    }

    /**
     * Gets query for [[LocationType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocationType()
    {
        return $this->hasOne(LocationTypes::class, ['location_type_id' => 'location_type_id']);
    }

    /**
     * Gets query for [[PropertyType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyType()
    {
        return $this->hasOne(PropertyTypes::class, ['property_type_id' => 'property_type_id']);
    }

     /**
     * Gets query for [[PropertyType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListingType()
    {
        return $this->hasOne(ListingTypes::class, ['id' => 'listing_types_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[TransactionStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionStatus()
    {
        return $this->hasOne(TransactionStatuses::class, ['transaction_status_id' => 'transaction_status_id']);
    }

    public function getDirection()
    {
        return $this->hasOne(Directions::class, ['id' => 'direction_id']);
    }

    public function getAssetType()
    {
        // Giả sử khóa ngoại trong bảng 'properties' là 'asset_type_id'
        // và nó liên kết đến 'asset_type_id' trong bảng của AssetType.
        return $this->hasOne(AssetTypes::class, ['asset_type_id' => 'asset_type_id']);
    }

    public function getPropertyInteriors()
    {
        return $this->hasMany(PropertyInteriors::class, ['property_id' => 'property_id']);
    }

    public function getInteriors()
    {
        return $this->hasMany(Interiors::class, ['interior_id' => 'interior_id'])
                    ->via(relationName: 'propertyInteriors');
    }

    public function getPropertyAdvantages()
    {
        return $this->hasMany(PropertyAdvantages::class, ['property_id' => 'property_id']);
    }


    public function getAdvantages() {
        return $this->hasMany(Advantages::class, ['advantage_id' => 'advantage_id'])
                ->via(relationName: 'propertyAdvantages');
    }


    public function getPropertyDisadvantages()
    {
        return $this->hasMany(PropertyDisadvantages::class, ['property_id' => 'property_id']);
    }

    public function getDisadvantages() {
        return $this->hasMany(Disadvantages::class, ['disadvantage_id' => 'disadvantage_id'])
                    ->via(relationName: 'propertyDisadvantages');
    }

    public function getPropertyImages()
    {
        return $this->hasMany(PropertyImages::class, ['property_id' => 'property_id']);
    }


    public function getRedbook()
    {
        return PropertyImages::find()
            ->where(['property_id' => $this->property_id, 'image_type' => 1])
            ->exists();
    }

    public function getRentalContract()
    {
        return $this->hasOne(RentalContracts::class, ['property_id' => 'property_id']);
    }

    public function getOwnerContacts()
    {
        return $this->hasMany(OwnerContacts::class, ['property_id' => 'property_id']);
    }

    public function getLocationTypes()
    {
        return $this->hasOne(LocationTypes::class, ['location_type_id' => 'location_type_id']);
    }

    public function getCurrencies()
    {
        return $this->hasOne(Currencies::class, ['id' => 'currency_id']);
    }

    /**
     * Gets query for [[PropertyUpdateLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyUpdateLogs()
    {
        return $this->hasMany(PropertyUpdateLog::class, ['property_id' => 'property_id']);
    }


    /**
     * Gets query for [[PropertyUpdateLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyLogs()
    {
        return $this->hasMany(PropertyLogs::class, ['property_id' => 'property_id']);
    }

    /**
     * Gets query for [[PropertyActionPhone]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActionHistory()
    {
        return $this->hasMany(PropertyActionPhone::class, ['property_id' => 'property_id']);
    }
}

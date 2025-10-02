<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Properties;

/**
 * PropertiesSearch represents the model behind the search form of `common\models\Properties`.
 */
class PropertiesSearch extends Properties
{
    public $keyword;
    public $price_from;
    public $price_to;
    public $district;
    public $ward;
    public $street;
    public $listing_type;
    public $direction;
    public $status_filters;
    public $area_from;
    public $area_to;
    public $location_type_id;
    public $property_type_id;
    public $asset_type_id;
    public $direction_ids;

    public $num_floors_from, $num_floors_to;

    public $num_bedrooms_from, $num_bedrooms_to;

    public $date_from, $date_to;
    public $listing_types_id;
    public $has_rental_contract;

    /**
     * {@inheritdoc}
     */
    public function rules()
{
    return [
        [['property_id', 'user_id', 'has_vat_invoice', 'num_toilets', 'num_bedrooms', 
          'num_basements', 'has_deposit', 'transaction_status_id', 'has_rental_contract', 
          'is_active', 'created_at', 'updated_at', 'num_floors', 'commission_types_id', 
          'commission_prices_id', 'property_images_id', 'num_floors_from', 'num_floors_to', 'num_bedrooms_from', 'num_bedrooms_to'], 'integer'],

        [['title', 'selling_price', 'house_number', 'street_name', 'ward_commune', 'district_county', 'city', 
          'compound_name', 'usable_area', 'land_type', 'description', 'transaction_description', 'external_id', 
          'plot_number', 'sheet_number', 'lot_number', 'keyword', 'district', 'ward', 'street', 
          'direction','location_type_id', 'property_type_id', 'status_filters','area_from', 'area_to', 
          'asset_type_id', 'direction_ids','date_from', 'date_to', 'listing_types_id'], 'safe'],

        [['area_width', 'area_length', 'area_total', 'planned_width', 'planned_length', 'planned_construction_area', 
          'area_back_side', 'wide_road', 'planned_back_side', 'price_from', 'price_to'], 'number'],

        [['price_from', 'price_to', 'area_from', 'area_to'], 'number'],
    ];
}

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Properties::find()
            ->where(['properties.is_active' => 1])
            ->with(['locationType', 'propertyType', 'transactionStatus', 'direction','assetType']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20],
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->listing_types_id)) {
            $query->andWhere(['properties.listing_types_id' => $this->listing_types_id]);
        }
        
        if (!empty($this->status_filters)) {
            $selectedIds = array_map('intval', explode(',', $this->status_filters));

            $logicMap = [
                'transaction_status_id' => [3, 4, 5, 6, 11],
                'selling_price_status_id' => [9, 10], // Giả sử bạn có cột này
                'auction_property' => 1, // ID 2 đã được tách ra cho logic riêng
                'new_product' => 2, // ID cho "Sản Phẩm Mới"
                'east_four_trach' => 7, // ID cho "Đông Tư Trạch"
                'west_four_trach' => 8, // ID cho "Tây Tứ Trạch" (Tẩy Trạch)
            ];
            $transactionStatusValueMap = [
                3 => 1, 4 => 2, 5 => 3, 11 => 4,
            ];

            $selectedFrontendTransactionIds = array_intersect($selectedIds, $logicMap['transaction_status_id']);

            $sellingPriceIds = array_intersect($selectedIds, $logicMap['selling_price_status_id']);
            $isAuctionPropertySelected = in_array($logicMap['auction_property'], $selectedIds);
            $isNewProductSelected = in_array($logicMap['new_product'], $selectedIds);
            $isEastFourTrachSelected = in_array($logicMap['east_four_trach'], $selectedIds);
            $isWestFourTrachSelected = in_array($logicMap['west_four_trach'], $selectedIds);

            if (!empty($selectedFrontendTransactionIds)) {
                $condition = ['or'];
                foreach ($selectedFrontendTransactionIds as $frontendId) {
                    if (isset($transactionStatusValueMap[$frontendId])) {
                        $condition[] = ['properties.transaction_status_id' => $transactionStatusValueMap[$frontendId]];
                    }

                    if ($frontendId === 6) {
                        $condition[] = ['properties.has_rental_contract' => 1];
                    }
                }
                if(count($condition) > 1){
                     $query->andWhere($condition);
                }
            }

            if (!empty($sellingPriceIds)) {
                $query->andWhere(['in', 'properties.selling_price_status_id', $sellingPriceIds]);
            }

            if ($isAuctionPropertySelected) {
                $query->andWhere(['properties.asset_type_id' => 6]);
            }

            if ($isNewProductSelected) {
                $oneWeekAgo = strtotime('-7 days');
                $query->andWhere(['>=', 'properties.created_at', $oneWeekAgo]);
            }

            $directionConditions = ['or'];
            if (!empty($directionIds)) {
                $directionConditions[] = ['in', 'properties.direction_id', $directionIds];
            }
            if ($isEastFourTrachSelected) {
                $directionConditions[] = ['in', 'properties.direction_id', [1, 3, 4, 8]];
            }
            if ($isWestFourTrachSelected) {
                $directionConditions[] = ['in', 'properties.direction_id', [2, 5, 6, 7]];
            }

            if (count($directionConditions) > 1) {
                $query->andWhere($directionConditions);
            }
        }

        if (!empty($this->location_type_id)) {
            $ids = explode(',', $this->location_type_id);
            $condition = ['or'];
            foreach ($ids as $id) {
                $condition[] = ['properties.location_type_id' => trim($id)];
            }
            if(count($condition) > 1){
                $query->andWhere($condition);
            }
        }

        if (!empty($this->property_type_id)) {
            $ids = explode(',', $this->property_type_id);
            $condition = ['or'];
            foreach ($ids as $id) {
                $condition[] = ['properties.property_type_id' => trim($id)];
            }
            if(count($condition) > 1){
                $query->andWhere($condition);
            }
        }
        
        $query->andFilterWhere(['>=', 'properties.area_width', $this->area_from]);
        $query->andFilterWhere(['<=', 'properties.area_length', $this->area_to]);
        $query->andFilterWhere(['between', 'properties.num_floors', $this->num_floors_from, $this->num_floors_to]);
        $query->andFilterWhere(['between', 'properties.num_bedrooms', $this->num_bedrooms_from, $this->num_bedrooms_to]);
        $query->andFilterWhere(['between', 'properties.price', $this->price_from, $this->price_to]);
        $query->andFilterWhere(['like', 'properties.plot_number', $this->plot_number]);
        $query->andFilterWhere(['like', 'properties.sheet_number', $this->sheet_number]);
        $query->andFilterWhere(['=', 'properties.district_county', $this->district_county]);

        if (!empty($this->keyword)) {
            $query->leftJoin('owner_contacts', 'owner_contacts.property_id = properties.property_id');
            $condition = ['or'];
            if (is_numeric($this->keyword)) {
                $condition[] = ['=', 'properties.house_number', $this->keyword];
            } else {
                $condition[] = ['like', 'properties.title', $this->keyword];
            }
            $condition[] = ['=', 'owner_contacts.phone_number', $this->keyword];
            $query->andWhere($condition);
        }
        
        if (!empty($this->date_from)) {
            $query->andWhere(['>=', 'properties.created_at', $this->date_from]);
        }

        if (!empty($this->date_to)) {
            $query->andWhere(['<=', 'properties.created_at', $this->date_to . ' 23:59:59']);
        }

        $multiSelectFilters = [
            'asset_type_id'    => $this->asset_type_id,
            'direction_id'     => $this->direction_ids,
        ];

        foreach ($multiSelectFilters as $column => $value) {
            if (!empty($value) && is_string($value)) {
                $ids = explode(',', $value);
                $ids = array_filter(array_map('trim', $ids));
                if (!empty($ids)) {
                    $query->andWhere(['in', 'properties.' . $column, $ids]);
                }
            }
        }

        return $dataProvider;
    }
}

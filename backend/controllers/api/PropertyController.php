<?php

namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use common\models\Properties;
use common\models\PropertiesSearch;
use common\models\PropertiesFrom;
use common\models\PropertyFavorite;
use common\models\Districts;
use common\models\Wards;
use common\models\Streets;
use common\models\Advantages;
use common\models\Disadvantages;
use yii\web\NotFoundHttpException;

class PropertyController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->response(false, 'Unauthorized');
        }

        $searchModel = new PropertiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (!$searchModel->validate()) {
            return $this->response(false, 'Invalid search parameters', ['errors' => $searchModel->getErrors()]);
        }

        $properties = $dataProvider->getModels();

        $imageDomain = Yii::$app->params['imageDomain'] ?? 'https://kinglandgroup.vn';

        $noImage[] = [
            'image_id' => 1,
            'image_path'=> 'https://app.bdsdaily.com/img/no-image.webp',
            'is_main' => 1,
            'sort_order' => 0
        ];

        $data = [];
        foreach ($properties as $property) {
            $images = [];
            foreach ($property->propertyImages as $image) {
                $images[] = [
                    'image_id' => $image->image_id,
                    'image_path' => rtrim($imageDomain, '/') . '/' . ltrim($image->image_path, '/'),
                    'is_main' => $image->is_main,
                    'sort_order' => $image->sort_order,
                ];
            }

            $contacts = [];
            foreach ($property->ownerContacts as $contact) {
                $contacts[] = [
                    'contact_id' => $contact->contact_id,
                    'contact_name' => $contact->contact_name,
                    'phone_number' => $contact->phone_number,
                    'role' => $contact->role ? $contact->role->name : null,
                    'gender' => $contact->gender ? $contact->gender->name : null,
                ];
            }

            $data[] = [
                'property_id' => $property->property_id,
                'title' => $property->title,
                'listing' =>$property->listingType->name,
                'property_type' => $property->propertyType ? $property->propertyType->type_name : null,
                'location_type' => $property->locationType ? $property->locationType->type_name : null,
                'price' => $property->price,
                'final_price' => $property->final_price,
                'area_total' => $property->area_total,
                'area_length' => $property->area_length,
                'area_width' => $property->area_width,
                'street_name' => $property->street_name,
                'ward_commune' => $property->ward_commune,
                'district_county' => $property->district_county,
                'city' => $property->city,
                'created_at' => $property->created_at,
                'updated_at' => $property->updated_at,
                'transaction_status' => $property->transactionStatus ? $property->transactionStatus->status_name : null,
                'property_type' => $property->propertyType ? $property->propertyType->type_name : null,
                'direction' => $property->direction ? $property->direction->name : null,
                'asset_type' => $property->assetType ? $property->assetType->type_name : null,
                'images' => count($images) > 0 ? $images : $noImage,
                'owner_contacts' => $contacts,
                'red_book' => $property->getRedbook()
            ];
        }

        $pagination = $dataProvider->getPagination();

        return $this->response(true, empty($data) ? 'No properties found' : 'Properties retrieved successfully', [
            'properties' => $data,
            'pagination' => [
                'total' => $pagination->totalCount,
                'page' => $pagination->getPage() + 1,
                'pageSize' => $pagination->pageSize,
                'totalPages' => $pagination->pageCount,
            ],
        ]);
    }

    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->response(false, 'Unauthorized');
        }

        $model = new PropertiesFrom();

        $data = Yii::$app->request->post();
        if ($model->load($data, '')) {
            if ($property = $model->save()) {
                return $this->response(true, 'Property created successfully', [
                    'property' => $property,
                ]);
            } else {
                return $this->response(false, 'Failed to save property', [
                    'errors' => $model->getErrors(),
                ]);
            }
        }

        return $this->response(false, 'Invalid input', [
            'errors' => $model->getErrors(),
        ]);
    }

    public function actionFavorites()
    {
        if (Yii::$app->user->isGuest) {
            return $this->response(false, 'Unauthorized');
        }
        $userId = Yii::$app->user->id;
        $favorites = PropertyFavorite::find()
            ->where(['user_id' => $userId])
            ->with(['property'])
            ->all();

        
        $data = array_map(function ($favorite) {
            $property = $favorite->property;
            $imageDomain = Yii::$app->params['imageDomain'] ?? 'https://app.bdsdaily.com';

            $noImage[] = [
                'image_id' => 1,
                'image_path'=> 'https://app.bdsdaily.com/img/no-image.webp',
                'is_main' => 1,
                'sort_order' => 0
            ];
            $images = [];
            foreach ($property->propertyImages as $image) {
                $images[] = [
                    'image_id' => $image->image_id,
                    'image_path' => rtrim($imageDomain, '/') . '/' . ltrim($image->image_path, '/'),
                    'is_main' => $image->is_main,
                    'sort_order' => $image->sort_order,
                ];
            }

            $contacts = [];
            foreach ($property->ownerContacts as $contact) {
                $contacts[] = [
                    'contact_id' => $contact->contact_id,
                    'contact_name' => $contact->contact_name,
                    'phone_number' => $contact->phone_number,
                    'role' => $contact->role ? $contact->role->name : null,
                    'gender' => $contact->gender ? $contact->gender->name : null,
                ];
            }
            return [
                'property_id' => $property->property_id,
                'title' => $property->title,
                'listing' =>$property->listingType->name,
                'property_type' => $property->propertyType ? $property->propertyType->type_name : null,
                'location_type' => $property->locationType ? $property->locationType->type_name : null,
                'price' => $property->price,
                'final_price' => $property->final_price,
                'area_total' => $property->area_total,
                'area_length' => $property->area_length,
                'area_width' => $property->area_width,
                'street_name' => $property->street_name,
                'ward_commune' => $property->ward_commune,
                'district_county' => $property->district_county,
                'city' => $property->city,
                'created_at' => $property->created_at,
                'updated_at' => $property->updated_at,
                'transaction_status' => $property->transactionStatus ? $property->transactionStatus->status_name : null,
                'property_type' => $property->propertyType ? $property->propertyType->type_name : null,
                'direction' => $property->direction ? $property->direction->name : null,
                'asset_type' => $property->assetType ? $property->assetType->type_name : null,
                'images' => count($images) > 0 ? $images : $noImage,
                'owner_contacts' => $contacts,
                'red_book' => $property->getRedbook()
            ];
        }, $favorites);

        return $this->response(true, 'Favorite properties retrieved successfully', data: [
            'properties' => $data,
        ]);
    }

    // API to add a favorite
    public function actionAddFavorite()
    {
        if (Yii::$app->user->isGuest) {
            return $this->response(false, 'Unauthorized');
        }

        $userId = Yii::$app->user->id;
        $propertyId = Yii::$app->request->post('property_id');

        if (!$propertyId) {
            return $this->response(false, 'Missing Mã property_id BĐS');
        }

        $existing = PropertyFavorite::findOne([
            'user_id' => $userId,
            'property_id' => $propertyId,
        ]);

        if ($existing !== null) {
            return $this->response(false, 'Bất động sản này đã có trong mục yêu thích của bạn');
        }

        $model = new PropertyFavorite();
        $model->user_id = $userId;
        $model->property_id = $propertyId;
        $model->created_at = date('Y-m-d H:i:s');

        if ($model->save()) {
            return $this->response(true, 'Đã thêm vào mục yêu thích', $model);
        }

        return $this->response(false, 'Không thể thêm vào mục yêu thích', $model->getErrors());
    }


    // API to remove a favorite
    public function actionRemoveFavorite()
    {
        if (Yii::$app->user->isGuest) {
            return $this->response(false, 'Unauthorized');
        }

        $propertyId = Yii::$app->request->post('property_id');

        if (!$propertyId) {
            return $this->response(false, 'Missing Mã property_id BĐS');
        }

        $model = PropertyFavorite::findOne([
            'user_id' => Yii::$app->user->id,
            'property_id' => $propertyId,
        ]);

        if (!$model) {
            return $this->response(false, 'không tìm thấy mục yêu thích');
        }

        if ($model->delete()) {
            return $this->response(true, 'Đã xóa khỏi mục yêu thích');
        }

        return $this->response(false, 'Không thể xóa khỏi mục yêu thích');
    }
    

    public function actionAddress($address) {

        $district = Districts::find()
            ->where(['Name' => $address])
            ->one();

        $wards = Wards::find()
            ->where(['DistrictId' => $district->id])
            ->all();

        $streets = Streets::find()
            ->where(['DistrictId' => $district->id])
            ->all();
        
        $data = [
            'wards' => $wards,
            'streets' =>$streets
        ];

        if (!empty($wards)) {
            return $this->response(true, 'Lấy danh sách Phường thành công ', $data);
        }
        return $this->response(false, 'Không có Danh sách');
    }

    /**
     * Finds the Properties model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $propertyId Property ID
     * @return Properties the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($propertyId) {
        $model = $this->findModel($propertyId);
        $images = [];
        $imageDomain = Yii::$app->params['imageDomain'] ?? 'https://app.bdsdaily.com';
        foreach ($model->propertyImages as $image) {
            $images[] = [
                'image_id' => $image->image_id,
                'image_path' => rtrim($imageDomain, '/') . '/' . ltrim($image->image_path, '/'),
                'is_main' => $image->is_main,
                'sort_order' => $image->sort_order,
            ];
        }

        $contacts = [];
        foreach ($model->ownerContacts as $contact) {
            $contacts[] = [
                'contact_id' => $contact->contact_id,
                'contact_name' => $contact->contact_name,
                'phone_number' => $contact->phone_number,
                'role' => $contact->role ? $contact->role->name : null,
                'gender' => $contact->gender ? $contact->gender->name : null,
            ];
        }

        $data = [
            'property' => $model,
            'advantages' => array_column($model->advantages, 'advantage_id'),
            'disadvantages' => array_column($model->disadvantages, 'disadvantage_id'),
            'images' => $images,
            'contacts' => $contacts,
        ];
        
        if (!empty($model)) {
            return $this->response(true, 'Get a property Success ', $data);
        }
    }

    /**
     * Finds the Properties model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $property_id Property ID
     * @return Properties the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($property_id)
    {
        if (($model = Properties::findOne(['property_id' => $property_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
   
    private function response($status, $msg, $data = null)
    {
        return [
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
        ];
    }
}
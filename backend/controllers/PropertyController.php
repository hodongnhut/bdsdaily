<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\Districts;
use common\models\Provinces;
use common\models\Advantages;
use common\models\AssetTypes;
use common\models\Directions;
use common\models\Properties;
use common\models\ListingTypes;
use common\models\Disadvantages;
use common\models\LocationTypes;
use common\models\PropertyTypes;
use common\models\PropertiesFrom;
use yii\web\NotFoundHttpException;
use common\models\PropertiesSearch;
use yii\filters\AccessControl; 
use common\models\PropertyInteriors;
use common\models\PropertyAdvantages;
use common\models\PropertyDisadvantages;
use common\models\OwnerContactSearch;
use common\models\RentalContracts;
use common\models\ActivityLogs;
use yii\web\UploadedFile;
use common\models\PropertyImages;
use common\models\PropertiesUserSearch;
use common\models\User;
use yii\web\Response;
use common\models\PropertyFavorite;
use yii\data\ActiveDataProvider;
use common\models\OwnerContacts;
use yii\web\ForbiddenHttpException;
use yii\db\Expression;
use common\models\UserActivities;
use common\models\PropertyUpdateLog;
use common\models\PropertyActionPhone;
use yii\helpers\Json;
class PropertyController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        // Refresh user model to ensure latest data
        if ($user) {
            $user = User::findOne($user->id);
        }
        $role_code = $user && $user->jobTitle ? $user->jobTitle->role_code : '';
        // Show modal if force_location_update is set and user is not manager/super_admin
        $locationRequired = $role_code && $role_code !== 'manager' && $role_code !== 'super_admin' 
            && Yii::$app->session->get('force_location_update', false);

        $model = new PropertiesFrom();
        $model->provinces = 50;
        $searchModel = new PropertiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'modelPropertyTypes' => PropertyTypes::find()->all(),
            'modelListingTypes' => ListingTypes::find()->all(),
            'modelLocationTypes' => LocationTypes::find()->all(),
            'modelAssetTypes' => AssetTypes::find()->all(),
            'modelAdvantages' => Advantages::find()->all(),
            'modelDisadvantages' => Disadvantages::find()->all(),
            'modelDirections' => Directions::find()->all(),
            'dataProvider' => $dataProvider,
            'model' => $model,
            'modelProvinces' => Provinces::find()->all(),
            'modelDistricts' => Districts::find()->where(['ProvinceId' => 50])->all(),
            'locationRequired' => $locationRequired
        ]);
    }

    /**
     * Displays a single Properties model.
     * @param int $property_id Property ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($property_id)
    {
        $userId = Yii::$app->user->id;
        $today = date('Y-m-d');

        // Tìm dòng user_activities hôm nay với action_type = 'view_property'
        $activity = UserActivities::find()
            ->where(['user_id' => $userId, 'action_type' => 'view_property'])
            ->andWhere(['between', 'created_at', $today . ' 00:00:00', $today . ' 23:59:59'])
            ->one();

        // Nếu đã đủ 300 lượt xem -> chặn
        if ($activity && $activity->count >= 300) {
            throw new ForbiddenHttpException('Bạn đã xem đủ 300 căn hôm nay. Vui lòng quay lại vào ngày mai.');
        }

        // Tăng hoặc tạo mới lượt xem
        if ($activity) {
            $activity->count += 1;
            $activity->save(false);
        } else {
            $activity = new UserActivities();
            $activity->user_id = $userId;
            $activity->action_type = 'view_property';
            $activity->count = 1;
            $activity->created_at = date('Y-m-d H:i:s');
            $activity->save(false);
        }

        // Lấy dữ liệu chi tiết BĐS
        $activityLogs = ActivityLogs::find()
            ->where(['property_id' => $property_id])
            ->with('user')
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        $modelActionPhone = PropertyActionPhone::find()
            ->where(['property_id' => $property_id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($property_id),
            'modelActivityLogs' => $activityLogs,
            'modelActionPhone' => $modelActionPhone,
        ]);
    }

    /**
     * Displays a single Properties model.
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUsers()
    {
        $searchModel = new PropertiesUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('users', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Properties model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PropertiesFrom();

        if ($this->request->isPost) {
            $property = $model->load($this->request->post()) ? $model->save() : null;
            if ($property !== null) {
                return $this->redirect(['update', 'property_id' => $property->property_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Properties model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $property_id Property ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($property_id)
    {
        $model = $this->findModel($property_id);
        $searchModel = new OwnerContactSearch();
        $searchModel->property_id = $property_id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $rentalContractModel = $model->rentalContract ?? new RentalContracts();
        
        if ($this->request->isPost && $model->load($this->request->post())) {
            

            $rentalContractModel->load($this->request->post());
            if ($rentalContractModel->isNewRecord) {
                $rentalContractModel->property_id = $model->property_id;
            }

            $isModelValid = $model->validate();
            $isRentalValid = true;
            if ($model->has_rental_contract) {
                $isRentalValid = $rentalContractModel->validate();
            }

            if ($isModelValid && $isRentalValid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($model->save(false)) { 
                        
                        if ($model->has_rental_contract) {
                            $rentalContractModel->save(false);
                        } elseif (!$rentalContractModel->isNewRecord) {
                            $rentalContractModel->delete();
                        }

                        if ($model->listing_types_id === 2) {
                            $interiorIds = Yii::$app->request->post('interiors', []);
                            PropertyInteriors::deleteAll(['property_id' => $model->property_id]);
                            foreach ($interiorIds as $interiorId) {
                                $relation = new PropertyInteriors();
                                $relation->property_id = $model->property_id;
                                $relation->interior_id = $interiorId;
                                $relation->save();
                            }
                        }
                        $advantagesIds = Yii::$app->request->post('advantages', []);
                        PropertyAdvantages::deleteAll(['property_id' => $model->property_id]);
                        foreach ($advantagesIds as $advantageId) { 
                            $advantage = new PropertyAdvantages();
                            $advantage->property_id = $model->property_id;
                            $advantage->advantage_id = $advantageId;
                            $advantage->save();
                        }

                        $disadvantagesIds = Yii::$app->request->post('disadvantages', []);
                        PropertyDisadvantages::deleteAll(['property_id' => $model->property_id]);
                        foreach ($disadvantagesIds as $disadvantageId) { 
                            $disadvantage = new PropertyDisadvantages();
                            $disadvantage->property_id = $model->property_id;
                            $disadvantage->disadvantage_id = $disadvantageId;
                            $disadvantage->save();
                        }

                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Cập nhật bất động sản thành công.');

                        \common\models\UserActivities::logActivity(Yii::$app->user->id, 'update_property');
                        
                        return $this->redirect(['view', 'property_id' => $model->property_id]);

                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Không thể lưu bất động sản. Vui lòng thử lại.');
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Có lỗi xảy ra khi lưu: ' . $e->getMessage());
                }
            } else {
                $errors = array_merge($model->getErrors(), $rentalContractModel->getErrors());
                $errorMessages = [];
                foreach ($errors as $errorList) {
                    $errorMessages = array_merge($errorMessages, $errorList);
                }
                Yii::$app->session->setFlash('error', 'Có lỗi trong dữ liệu nhập: ' . implode(', ', $errorMessages));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelProvinces' => Provinces::find()->all(),
            'modelDistricts' => Districts::find()->where(['ProvinceId' => 50])->all(),
            'modelPropertyTypes' => PropertyTypes::find()->all(),
            'rentalContractModel' => $rentalContractModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Properties model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $property_id Property ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($property_id)
    {
        if (Yii::$app->user->identity->jobTitle->role_code === 'manager' ||  Yii::$app->user->identity->jobTitle->role_code == 'super_admin') {
            $this->findModel($property_id)->delete();

            return $this->redirect(['index']);
        }
        throw new \yii\web\ForbiddenHttpException('Bạn không có quyền xóa');
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


    /**
     * Uploads images via AJAX.
     * @return array JSON response
     */
    public function actionUploadImage()
    {
        try {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $response = ['success' => false, 'message' => '', 'images' => []];
            
            $files = UploadedFile::getInstancesByName('files');
            $type = Yii::$app->request->post('type');
            $propertyId = Yii::$app->request->post('property_id', 0);

            if (empty($files)) {
                $response['message'] = 'Vui lòng chọn ít nhất một file để tải lên.';
                return $response;
            }

            if (count($files) > 10) {
                $response['message'] = 'Chỉ được tải tối đa 10 file mỗi lần. Bạn đã chọn ' . count($files) . ' file.';
                return $response;
            }

            if ($propertyId == 0) {
                $response['message'] = 'ID bất động sản không hợp lệ.';
                return $response;
            }

            $sortOrder = PropertyImages::find()->where(['property_id' => $propertyId])->max('sort_order') + 1;

            foreach ($files as $file) {
                $allowedExtensions = ['pdf', 'jpg', 'png', 'jpeg', 'webp', 'heic'];
                if (!in_array(strtolower($file->extension), $allowedExtensions)) {
                    $response['message'] = 'Định dạng file không hợp lệ: ' . $file->name;
                    return $response;
                }

                $imageModel = new PropertyImages();
                $imageModel->property_id = $propertyId;
                $imageModel->image_path = '/uploads/properties/' . time() . '_' . uniqid() . '.' . $file->extension;
                $imageModel->image_type = ($type === 'legal') ? 1 : 0;
                $imageModel->is_main = 0;
                $imageModel->sort_order = $sortOrder++;
                
                $filePath = Yii::getAlias('@webroot') . $imageModel->image_path;
                if ($file->saveAs($filePath)) {
                    if ($imageModel->save()) {
                        $response['images'][] = [
                            'id' => $imageModel->image_id,
                            'url' => Yii::$app->urlManager->createAbsoluteUrl($imageModel->image_path),
                            'name' => $file->name
                        ];
                    } else {
                        $errors = $imageModel->getErrors();
                        Yii::error("PropertyImages save errors: " . json_encode($errors), __METHOD__);
                        $response['message'] = 'Không thể lưu thông tin hình ảnh vào cơ sở dữ liệu: ' . implode(', ', $imageModel->getErrorSummary(true));
                        return $response;
                    }
                } else {
                    $response['message'] = 'Không thể lưu file: ' . $file->name;
                    return $response;
                }
            }

            try {
                $log = new PropertyUpdateLog();
                $log->property_id = $propertyId;
                $log->data = $propertyId;
                $log->rendered_html_content = Json::encode(\common\helpers\HtmlLogHelper::renderImagetHTML($propertyId));
                $log->created_at = time();
                $log->created_by = Yii::$app->user->id ?? null;
                if (!$log->save(false)) {
                    Yii::error('Failed to save property update log: ' . json_encode($log->errors), 'property_update_log');
                }
            } catch (\Throwable $th) {
                Yii::error($th->getMessage());
            }

            $response['success'] = true;

            $response['message'] = 'Tải lên thành công';
            return $response;
            
        } catch (\Exception $e) {
            
            return [
                'success' => false,
                'message' => 'Lỗi bạn Upload quá nhiều ảnh trong một lần',
                'images' => []
            ];
        }
       
    }

    /**
     * Deletes an image via AJAX.
     * @return array JSON response
     */
    public function actionDeleteImage()
    {
        try {

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $response = ['success' => false, 'message' => ''];

            $imageId = Yii::$app->request->post('image_id');
            $image = PropertyImages::findOne($imageId);

            if (!$image) {
                $response['message'] = 'Hình ảnh không tồn tại.';
                return $response;
            }

            $filePath = Yii::getAlias('@backend/web/' . $image->image_path);

            if (file_exists($filePath)) {
                if ($image->delete()) {
                    $otherImage = PropertyImages::find()
                        ->where(['property_id' => $image->property_id])
                        ->andWhere(['!=', 'image_id', $imageId])
                        ->orderBy(['sort_order' => SORT_ASC])
                        ->one();
                    if ($otherImage && $image->is_main) {
                        $otherImage->is_main = 1;
                        $otherImage->save();
                    }
                    $response['success'] = true;
                    $response['message'] = 'Xóa hình ảnh thành công.';
                } else {
                    $response['message'] = 'Không thể xóa thông tin hình ảnh khỏi cơ sở dữ liệu.';
                }
            } else {
                if ($image->delete()) {
                    $otherImage = PropertyImages::find()
                        ->where(['property_id' => $image->property_id])
                        ->andWhere(['!=', 'image_id', $imageId])
                        ->orderBy(['sort_order' => SORT_ASC])
                        ->one();
                    if ($otherImage && $image->is_main) {
                        $otherImage->is_main = 1;
                        $otherImage->save();
                    }
                    $response['success'] = true;
                    $response['message'] = 'Xóa hình ảnh thành công.';
                } else {
                    $response['message'] = 'Không thể xóa thông tin hình ảnh khỏi cơ sở dữ liệu.';
                }
                $response['message'] = 'Không thể xóa file hình ảnh.';
            }

            return $response;
        }catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'images' => []
            ];
        }
    }

    /**
     * Toggles a property as favorite/unfavorite for the current user via AJAX.
     * @return array JSON response
     */
    public function actionToggleFavorite()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->request->isPost) {
            return ['success' => false, 'message' => 'Yêu cầu không hợp lệ.'];
        }

        $propertyId = Yii::$app->request->post('property_id');
        $userId = Yii::$app->user->id;

        if (!is_numeric($propertyId) || $propertyId <= 0) {
            return ['success' => false, 'message' => 'ID tài sản không hợp lệ.'];
        }

        if (!Properties::find()->where(['property_id' => $propertyId])->exists()) {
             return ['success' => false, 'message' => 'Tài sản không tồn tại.'];
        }

        $favorite = PropertyFavorite::find()
            ->where(['user_id' => $userId, 'property_id' => $propertyId])
            ->one();

        if ($favorite) {
            if ($favorite->delete()) {
                return ['success' => true, 'status' => 'removed', 'message' => 'Đã xóa khỏi mục yêu thích.'];
            } else {
                return ['success' => false, 'message' => 'Không thể xóa khỏi mục yêu thích.'];
            }
        } else {
            $newFavorite = new PropertyFavorite();
            $newFavorite->user_id = $userId;
            $newFavorite->property_id = $propertyId;

            if ($newFavorite->save()) {
                return ['success' => true, 'status' => 'added', 'message' => 'Đã thêm vào mục yêu thích.'];
            } else {
                Yii::error('Failed to save favorite: ' . json_encode($newFavorite->getErrors()), __METHOD__);
                return ['success' => false, 'message' => 'Không thể thêm vào mục yêu thích.'];
            }
        }
    }

    /**
     * Displays a list of properties favorited by the current user.
     * Hiển thị danh sách các tài sản được người dùng hiện tại yêu thích.
     * @return string
     */
    public function actionMyFavorites()
    {
        $userId = Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => PropertyFavorite::find()
                ->where(['user_id' => $userId])
                ->with('property'),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('my-favorites', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetPhone()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $contactId = Yii::$app->request->post('contact_id');
        if (!$contactId) {
            return ['success' => false, 'error' => 'Contact ID is required.'];
        }
        $contact = OwnerContacts::findOne($contactId);
        if (!$contact) {
            return ['success' => false, 'error' => 'Contact not found.'];
        }
        try {
            $action = new PropertyActionPhone();
            $action->property_id = $contact->property_id;
            $action->user_id = Yii::$app->user->id;
            $action->action = 'view';
            $action->phone_number = $contact->phone_number;
            if (!$action->save(false)) {
                Yii::error('Failed to save PropertyActionPhone: ' . json_encode($action->errors), 'property_update_log');
            }
        } catch (\Throwable $th) {
            Yii::error($th->getMessage());
        }

        $logResult = UserActivities::logActivityPhone(Yii::$app->user->id, 'view_phone', 300);
        if (!$logResult) {
            return ['success' => false, 'error' => 'Bạn đã xem đủ 300 số điện thoại hôm nay. Vui lòng quay lại vào ngày mai.'];
        }
        if (Yii::$app->user->isGuest) {
            return ['success' => false, 'error' => 'Unauthorized access.'];
        }

        return ['success' => true, 'phone_number' => $contact->phone_number];
    }
}

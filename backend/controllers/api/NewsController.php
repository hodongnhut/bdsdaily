<?php

namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use common\models\News;
use common\models\NewsSearch;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class NewsController extends Controller
{
   
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }

    /**
     * List news - tái sử dụng NewsSearch như web
     * GET /api/news
     * Support search, filter category/status/title + pagination giống GridView web
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $models = $dataProvider->getModels();

        $newsList = [];
        foreach ($models as $model) {
            $newsList[] = [
                'id' => $model->id,
                'title' => $model->title,
                'slug' => $model->slug,
                'short_description' => $model->short_description,
                'content' => $model->content,
                'image_url' => $model->image_path ? Yii::getAlias('@web') . $model->image_path : null,
                'status' => $model->status === News::STATUS_PUBLISHED ? 'Published' : 'Draft',
                'status_code' => $model->status,
                'created_at' => date('Y-m-d H:i:s', $model->created_at),
                'updated_at' => date('Y-m-d H:i:s', $model->updated_at),
            ];
        }

        return [
            'status' => true,
            'msg' => 'Lấy danh sách tin tức thành công',
            'data' => $newsList,
            'pagination' => [
                'total_count' => $dataProvider->getTotalCount(),
                'page_count' => $dataProvider->pagination->getPageCount(),
                'current_page' => $dataProvider->pagination->getPage() + 1, 
                'page_size' => $dataProvider->pagination->pageSize,
            ],
            'sort' => [
                'current' => $dataProvider->sort->getOrders(),
                'attributes' => array_keys($dataProvider->sort->attributes),
            ]
        ];
    }

    /**
     * View single news
     * GET /api/news/{id}
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        // Chỉ cho xem nếu đã published (hoặc admin được xem draft)
        $currentUser = Yii::$app->user->identity;
        $currentRole = $currentUser && $currentUser->jobTitle ? $currentUser->jobTitle->role_code : null;

        if ($model->status === News::STATUS_DRAFT && !in_array($currentRole, ['manager', 'super_admin'])) {
            throw new ForbiddenHttpException('Bạn không có quyền xem bản nháp này.');
        }

        return [
            'status' => true,
            'msg' => 'Lấy tin tức thành công',
            'data' => [
                'id' => $model->id,
                'title' => $model->title,
                'slug' => $model->slug,
                'short_description' => $model->short_description,
                'content' => $model->content,
                'image_url' => $model->image_path ? Yii::getAlias('@web') . $model->image_path : null,
                'status' => $model->status === News::STATUS_PUBLISHED ? 'Published' : 'Draft',
                'category' => $model->category ? [
                    'id' => $model->category->id,
                    'name' => $model->category->name,
                ] : null,
                'created_by' => $model->createdBy ? $model->createdBy->full_name ?? $model->createdBy->username : null,
                'created_at' => date('Y-m-d H:i:s', $model->created_at),
                'updated_at' => date('Y-m-d H:i:s', $model->updated_at),
            ]
        ];
    }

    /**
     * Create news + upload image
     * POST /api/news
     */
    public function actionCreate()
    {
        $model = new News();
        $model->load(Yii::$app->request->post(), '');

        // Xử lý upload ảnh
        $model->imageFile = UploadedFile::getInstanceByName('imageFile');
        if ($model->imageFile) {
            $uploadPath = '/uploads/news/' . date('Y/m/d') . '/';
            $fullPath = Yii::getAlias('@webroot') . $uploadPath;
            if (!is_dir($fullPath)) {
                \yii\helpers\FileHelper::createDirectory($fullPath);
            }

            $fileName = Yii::$app->security->generateRandomString(12) . '.' . $model->imageFile->extension;
            if ($model->imageFile->saveAs($fullPath . $fileName)) {
                $model->image_path = $uploadPath . $fileName;
            }
        }

        // Tự động set created_by, created_at (beforeSave đã xử lý phần slug, updated)
        $model->created_by = Yii::$app->user->id;

        if ($model->save()) {
            Yii::$app->response->statusCode = 201;
            return [
                'status' => true,
                'msg' => 'Tạo tin tức thành công',
                'data' => [
                    'id' => $model->id,
                    'title' => $model->title,
                    'slug' => $model->slug,
                    'image_url' => $model->image_path ? Yii::getAlias('@web') . $model->image_path : null,
                ]
            ];
        }

        return [
            'status' => false,
            'msg' => 'Tạo tin tức thất bại',
            'data' => $model->getErrors(),
        ];
    }

    /**
     * Update news + upload image (nếu có)
     * PUT/PATCH /api/news/{id}
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->load(Yii::$app->request->post(), '');

        // Upload ảnh mới (nếu có)
        $model->imageFile = UploadedFile::getInstanceByName('imageFile');
        if ($model->imageFile) {
            // Xóa ảnh cũ nếu cần
            if ($model->image_path && file_exists(Yii::getAlias('@webroot') . $model->image_path)) {
                unlink(Yii::getAlias('@webroot') . $model->image_path);
            }

            $uploadPath = '/uploads/news/' . date('Y/m/d') . '/';
            $fullPath = Yii::getAlias('@webroot') . $uploadPath;
            if (!is_dir($fullPath)) {
                \yii\helpers\FileHelper::createDirectory($fullPath);
            }

            $fileName = Yii::$app->security->generateRandomString(12) . '.' . $model->imageFile->extension;
            if ($model->imageFile->saveAs($fullPath . $fileName)) {
                $model->image_path = $uploadPath . $fileName;
            }
        }

        $model->updated_by = Yii::$app->user->id;

        if ($model->save()) {
            return [
                'status' => true,
                'msg' => 'Cập nhật tin tức thành công',
                'data' => [
                    'id' => $model->id,
                    'title' => $model->title,
                    'image_url' => $model->image_path ? Yii::getAlias('@web') . $model->image_path : null,
                ]
            ];
        }

        return [
            'status' => false,
            'msg' => 'Cập nhật thất bại',
            'data' => $model->getErrors(),
        ];
    }

    /**
     * Delete news
     * DELETE /api/news/{id}
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Xóa ảnh nếu có
        if ($model->image_path && file_exists(Yii::getAlias('@webroot') . $model->image_path)) {
            unlink(Yii::getAlias('@webroot') . $model->image_path);
        }

        if ($model->delete()) {
            return [
                'status' => true,
                'msg' => 'Xóa tin tức thành công',
                'data' => null,
            ];
        }

        return [
            'status' => false,
            'msg' => 'Xóa thất bại',
            'data' => $model->getErrors(),
        ];
    }

    /**
     * Find model or throw 404
     */
    protected function findModel($id)
    {
        $model = News::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Tin tức không tồn tại.');
        }
        return $model;
    }
}
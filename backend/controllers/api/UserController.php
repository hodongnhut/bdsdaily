<?php

namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\UserSearch;
use common\models\SignupForm;

class UserController extends Controller
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
     * List users - tái sử dụng UserSearch như web
     * GET /api/users
     * Support search & pagination giống actionIndex web
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Chỉ lấy các field cần thiết
        $models = $dataProvider->getModels();
        $users = [];
        foreach ($models as $model) {
            $users[] = [
                'id' => $model->id,
                'username' => $model->username,
                'email' => $model->email,
                'full_name' => $model->full_name,
                'phone' => $model->phone,
                'status' => $model->status,
                'created_at' => date('Y-m-d H:i:s', $model->created_at),
                'updated_at' => date('Y-m-d H:i:s', $model->updated_at),
            ];
        }

        return [
            'status' => true,
            'msg' => 'Lấy danh sách người dùng thành công',
            'data' => $users,
            'pagination' => [
                'total' => $dataProvider->getTotalCount(),
                'page' => $dataProvider->pagination->page + 1,
                'pageSize' => $dataProvider->pagination->pageSize,
            ]
        ];
    }

    /**
     * View single user - tái sử dụng findModel
     * GET /api/users/{id}
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return [
            'status' => true,
            'msg' => 'Lấy thông tin người dùng thành công',
            'data' => [
                'id' => $model->id,
                'username' => $model->username,
                'email' => $model->email,
                'full_name' => $model->full_name,
                'phone' => $model->phone,
                'status' => $model->status,
                'created_at' => date('Y-m-d H:i:s', $model->created_at),
                'updated_at' => date('Y-m-d H:i:s', $model->updated_at),
            ]
        ];
    }

    /**
     * Create new user - tái sử dụng SignupForm như actionCreate web
     * POST /api/users
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post(), '') && $model->signup()) {
            Yii::$app->response->statusCode = 201;

            return [
                'status' => true,
                'msg' => 'Tạo người dùng thành công',
                'data' => [
                    'id' => $model->id ?? null,
                    'username' => $model->username,
                    'email' => $model->email,
                    'full_name' => $model->full_name,
                ]
            ];
        }

        return [
            'status' => false,
            'msg' => 'Tạo người dùng thất bại',
            'data' => $model->getErrors(),
        ];
    }

    /**
     * Update user - tái sử dụng logic update như web
     * PUT/PATCH /api/users/{id}
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return [
                'status' => true,
                'msg' => 'Cập nhật người dùng thành công',
                'data' => [
                    'id' => $model->id,
                    'username' => $model->username,
                    'email' => $model->email,
                    'full_name' => $model->full_name,
                    'phone' => $model->phone,
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
     * Delete user - giống actionDelete web
     * DELETE /api/users/{id}
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return [
            'status' => true,
            'msg' => 'Xóa người dùng thành công',
            'data' => null,
        ];
    }

    /**
     * Tái sử dụng findModel từ controller web
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Người dùng không tồn tại.');
    }
}
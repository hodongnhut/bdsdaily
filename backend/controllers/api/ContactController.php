<?php

namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use common\models\SalesContact;
use yii\web\NotFoundHttpException;

/**
 * API Controller cho SalesContact (liên hệ bán hàng)
 */
class ContactController extends Controller
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
     * Danh sách tất cả liên hệ
     * GET /api/contact
     */
    public function actionIndex()
    {
        return SalesContact::find()->orderBy(['id' => SORT_DESC])->asArray()->all();
    }

    /**
     * Xem chi tiết liên hệ
     * GET /api/contact/view?id=1
     */
    public function actionView($id)
    {
        $model = SalesContact::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Không tìm thấy liên hệ ID: $id");
        }

        return $model->toArray();
    }

    /**
     * Tạo mới liên hệ
     * POST /api/contact/create
     * Body: { "name": "...", "email": "...", "phone": "..." }
     */
    public function actionCreate()
    {
        $model = new SalesContact();
        $model->load(Yii::$app->request->post(), '');

        if ($model->save()) {
            Yii::$app->response->statusCode = 201;
            return [
                'status' => 'success',
                'message' => 'Tạo liên hệ thành công!',
                'data' => $model->toArray(),
            ];
        }

        Yii::$app->response->statusCode = 400;
        return [
            'status' => 'error',
            'message' => 'Dữ liệu không hợp lệ',
            'errors' => $model->getErrors(),
        ];
    }

    /**
     * Cập nhật liên hệ
     * PUT /api/contact/update?id=1
     * Body: { "name": "...", "phone": "..." }
     */
    public function actionUpdate($id)
    {
        $model = SalesContact::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Không tìm thấy liên hệ ID: $id");
        }

        $model->load(Yii::$app->request->bodyParams, '');
        if ($model->save()) {
            return [
                'status' => 'success',
                'message' => 'Cập nhật thành công!',
                'data' => $model->toArray(),
            ];
        }

        Yii::$app->response->statusCode = 400;
        return [
            'status' => 'error',
            'message' => 'Lỗi khi cập nhật',
            'errors' => $model->getErrors(),
        ];
    }

    /**
     * Xóa liên hệ
     * DELETE /api/contact/delete?id=1
     */
    public function actionDelete($id)
    {
        $model = SalesContact::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Không tìm thấy liên hệ ID: $id");
        }

        $model->delete();

        return [
            'status' => 'success',
            'message' => "Đã xóa liên hệ ID: $id",
        ];
    }
}
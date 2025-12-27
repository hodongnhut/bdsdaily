<?php

namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use common\models\Posts;
use yii\web\NotFoundHttpException;

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
     * List posts với filter + pagination
     * GET /api/posts
     * Hỗ trợ query params:
     *   ?post_type=NEWS
     *   ?category_id=5
     *   ?is_active=1
     *   ?search=keyword (tìm trong title)
     *   ?page=2&per-page=20
     */
    public function actionIndex()
    {
        $query = Posts::find()
            ->with(['category', 'attachments'])
            ->orderBy(['post_date' => SORT_DESC]);

        // Filter theo query params
        $request = Yii::$app->request;

        if ($request->get('post_type')) {
            $query->andWhere(['post_type' => $request->get('post_type')]);
        }

        if ($request->get('category_id')) {
            $query->andWhere(['category_id' => $request->get('category_id')]);
        }

        if ($request->get('is_active') !== null) {
            $query->andWhere(['is_active' => (int)$request->get('is_active')]);
        }

        if ($search = $request->get('search')) {
            $query->andWhere(['like', 'post_title', $search]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $request->get('per-page', 20),
            ],
            'sort' => [
                'defaultOrder' => ['post_date' => SORT_DESC],
                'attributes' => ['post_date', 'post_title', 'post_type'],
            ],
        ]);
    }

    /**
     * View single post
     * GET /api/posts/{id}
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        // Chỉ hiển thị nếu active (trừ admin)
        $currentUser = Yii::$app->user->identity;
        $currentRole = $currentUser && $currentUser->jobTitle ? $currentUser->jobTitle->role_code : null;

        if ($model->is_active == 0 && !in_array($currentRole, ['manager', 'super_admin'])) {
            throw new \yii\web\ForbiddenHttpException('Bạn không có quyền xem bài viết này.');
        }

        return [
            'status' => true,
            'msg' => 'Lấy bài viết thành công',
            'data' => [
                'post_id' => $model->post_id,
                'post_title' => $model->post_title,
                'post_content' => $model->post_content,
                'post_type' => $model->post_type,
                'post_type_label' => $model->displayPostType(),
                'post_date' => $model->post_date,
                'is_active' => $model->is_active,
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at,
                'category' => $model->category ? [
                    'category_id' => $model->category->category_id,
                    'name' => $model->category->category_name ?? 'Chưa phân loại',
                ] : null,
                'attachments' => array_map(function($attach) {
                    return [
                        'id' => $attach->attachment_id,
                        'file_name' => $attach->file_name,
                        'file_path' => Yii::getAlias('@web') . $attach->file_path,
                        'file_type' => $attach->file_type,
                    ];
                }, $model->attachments),
            ]
        ];
    }

    /**
     * Find model or throw 404
     */
    protected function findModel($id)
    {
        $model = Posts::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Bài viết không tồn tại.');
        }
        return $model;
    }
}
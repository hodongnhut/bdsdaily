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
     * Query params:
     *   ?post_type=NEWS
     *   ?category_id=5
     *   ?is_active=1
     *   ?search=keyword
     *   ?page=2&per-page=20
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;

        $query = Posts::find()
            ->with(['category', 'attachments']) // Eager loading quan hệ
            ->orderBy(['post_date' => SORT_DESC]);

        // Filter theo query params
        if ($postType = $request->get('post_type')) {
            $query->andWhere(['post_type' => $postType]);
        }

        if ($categoryId = $request->get('category_id')) {
            $query->andWhere(['category_id' => (int)$categoryId]);
        }

        if ($request->get('is_active') !== null) {
            $query->andWhere(['is_active' => (int)$request->get('is_active')]);
        }

        if ($search = $request->get('search')) {
            $query->andWhere(['like', 'post_title', $search]);
        }

        // Tạo DataProvider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => (int)$request->get('per-page', 20),
            ],
            'sort' => [
                'defaultOrder' => ['post_date' => SORT_DESC],
                'attributes' => ['post_date', 'post_title', 'post_type', 'is_active'],
            ],
        ]);

        // Chuyển models thành mảng dữ liệu JSON đẹp
        $posts = [];
        foreach ($dataProvider->getModels() as $model) {
            /** @var Posts $model */
            $posts[] = [
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
                    'category_name' => $model->category->category_name ?? 'Chưa phân loại',
                ] : null,
                'attachments' => array_map(function ($attach) {
                    return [
                        'attachment_id' => $attach->attachment_id ?? null,
                        'file_name' => $attach->file_name,
                        'file_path' => $attach->file_path ? Yii::getAlias('@web') . $attach->file_path : null,
                        'file_type' => $attach->file_type,
                    ];
                }, $model->attachments),
            ];
        }

        // Trả về JSON chuẩn API
        return [
            'status' => true,
            'msg' => 'Lấy danh sách bài viết thành công',
            'data' => $posts,
            'pagination' => [
                'total_count' => $dataProvider->getTotalCount(),
                'page_count' => $dataProvider->pagination->getPageCount(),
                'current_page' => $dataProvider->pagination->getPage() + 1, // Yii2 page bắt đầu từ 0
                'page_size' => $dataProvider->pagination->pageSize,
            ],
        ];
    }

    /**
     * View single post
     * GET /api/posts/{id}
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);


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
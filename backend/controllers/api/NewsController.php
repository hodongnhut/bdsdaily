<?php

namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use common\models\Posts;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
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
     * List posts với filter + pagination
     * GET /api/posts
     * Query params mới:
     *   ?is_active=1   → chỉ lấy bài đang active
     *   ?is_active=0   → chỉ lấy bài bị ẩn
     *   ?is_active=all → lấy tất cả (không filter is_active) - chỉ dành cho admin
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;

        $query = Posts::find()
            ->with(['category', 'attachments'])
            ->orderBy(['post_date' => SORT_DESC]); // Mới nhất trước

        // === FILTER THEO QUERY PARAMS ===
        
        // 1. post_type
        if ($postType = $request->get('post_type')) {
            if (array_key_exists($postType, Posts::optsPostType())) {
                $query->andWhere(['post_type' => $postType]);
            } else {
                // Nếu post_type không hợp lệ → trả về rỗng
                return [
                    'status' => false,
                    'msg' => 'Kiểu bài viết không hợp lệ.',
                    'data' => [],
                    'pagination' => [
                        'total_count' => 0,
                        'page_count' => 0,
                        'current_page' => 1,
                        'page_size' => 20,
                    ]
                ];
            }
        }

        // 2. category_id
        if ($categoryId = $request->get('category_id')) {
            $query->andWhere(['category_id' => (int)$categoryId]);
        }

        // 3. is_active - LOGIC MỚI & CHÍNH XÁC
        $isActiveParam = $request->get('is_active');

        if ($isActiveParam !== null) {
            $isActive = (int)$isActiveParam;

            // Nếu param là 1 hoặc 0 → filter chính xác
            if (in_array($isActive, [0, 1])) {
                $query->andWhere(['is_active' => $isActive]);
            }
            // Nếu param là "all" → chỉ admin mới được xem tất cả (active + inactive)
            elseif (strtolower($isActiveParam) === 'all') {
                $currentUser = Yii::$app->user->identity;
                $currentRole = $currentUser && $currentUser->jobTitle ? $currentUser->jobTitle->role_code : null;

                if (!in_array($currentRole, ['manager', 'super_admin'])) {
                    throw new \yii\web\ForbiddenHttpException('Bạn không có quyền xem tất cả bài viết (bao gồm bài bị ẩn).');
                }
                // Không filter is_active → hiển thị tất cả
            } else {
                // Giá trị không hợp lệ
                return [
                    'status' => false,
                    'msg' => 'Tham số is_active không hợp lệ. Chỉ chấp nhận 0, 1 hoặc "all" (cho admin).',
                    'data' => [],
                    'pagination' => [
                        'total_count' => 0,
                        'page_count' => 0,
                        'current_page' => 1,
                        'page_size' => 20,
                    ]
                ];
            }
        } else {
            // Mặc định: chỉ hiển thị bài active (is_active = 1) cho người dùng thường
            $query->andWhere(['is_active' => 1]);
        }

        // 4. search theo tiêu đề
        if ($search = $request->get('search')) {
            $query->andWhere(['like', 'post_title', $search]);
        }

        // === DATA PROVIDER ===
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

        // === CHUYỂN ĐỔI THÀNH JSON ===
        $posts = [];
        foreach ($dataProvider->getModels() as $model) {
            $posts[] = [
                'post_id' => $model->post_id,
                'post_title' => $model->post_title,
                'post_content' => $model->post_content,
                'post_type' => $model->post_type,
                'post_type_label' => $model->displayPostType(),
                'post_date' => $model->post_date,
                'is_active' => (bool)$model->is_active,
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

        return [
            'status' => true,
            'msg' => 'Lấy danh sách bài viết thành công',
            'data' => $posts,
            'pagination' => [
                'total_count' => $dataProvider->getTotalCount(),
                'page_count' => $dataProvider->pagination->getPageCount(),
                'current_page' => $dataProvider->pagination->getPage() + 1,
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

    /**
     * Create new post
     * POST /api/posts
     * Body: JSON hoặc form-data
     */
    public function actionCreate()
    {
        $currentUser = Yii::$app->user->identity;

        if (!$currentUser) {
            throw new UnauthorizedHttpException('Bạn cần đăng nhập để xem thông tin người dùng.');
        }

        $currentRole = $currentUser->jobTitle ? $currentUser->jobTitle->role_code : null;

        $allowedRoles = ['manager', 'super_admin'];
        if (!in_array($currentRole, $allowedRoles)) {
            throw new ForbiddenHttpException('Bạn không có quyền xem thông tin người dùng này.');
        }
        $model = new Posts();

        if ($model->load(Yii::$app->request->post(), '')) {
            if (!array_key_exists($model->post_type, Posts::optsPostType())) {
                return [
                    'status' => false,
                    'msg' => 'Kiểu bài viết không hợp lệ.',
                    'data' => ['post_type' => ['Kiểu bài viết không hợp lệ.']]
                ];
            }

            $model->is_active = $model->is_active ?? 1;

            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->response->statusCode = 201;

                return [
                    'status' => true,
                    'msg' => 'Tạo bài viết thành công',
                    'data' => [
                        'post_id' => $model->post_id,
                        'post_title' => $model->post_title,
                        'post_type' => $model->post_type,
                        'post_type_label' => $model->displayPostType(),
                        'post_date' => $model->post_date,
                        'is_active' => $model->is_active,
                    ]
                ];
            }
        }

        return [
            'status' => false,
            'msg' => 'Tạo bài viết thất bại',
            'data' => $model->getErrors(),
        ];
    }

    /**
     * Update existing post
     * PUT hoặc PATCH /api/posts/{id}
     */
    public function actionUpdate($id)
    {
        $currentUser = Yii::$app->user->identity;

        if (!$currentUser) {
            throw new UnauthorizedHttpException('Bạn cần đăng nhập để xem thông tin người dùng.');
        }

        $currentRole = $currentUser->jobTitle ? $currentUser->jobTitle->role_code : null;


        $allowedRoles = ['manager', 'super_admin'];
        if (!in_array($currentRole, $allowedRoles)) {
            throw new ForbiddenHttpException('Bạn không có quyền xem thông tin người dùng này.');
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post(), '')) {
            if ($model->isAttributeChanged('post_type') && !array_key_exists($model->post_type, Posts::optsPostType())) {
                return [
                    'status' => false,
                    'msg' => 'Kiểu bài viết không hợp lệ.',
                    'data' => ['post_type' => ['Kiểu bài viết không hợp lệ.']]
                ];
            }

            $model->updated_at = date('Y-m-d H:i:s');

            if ($model->save()) {
                return [
                    'status' => true,
                    'msg' => 'Cập nhật bài viết thành công',
                    'data' => [
                        'post_id' => $model->post_id,
                        'post_title' => $model->post_title,
                        'post_type' => $model->post_type,
                        'post_type_label' => $model->displayPostType(),
                        'post_date' => $model->post_date,
                        'is_active' => $model->is_active,
                        'updated_at' => $model->updated_at,
                    ]
                ];
            }
        }

        return [
            'status' => false,
            'msg' => 'Cập nhật bài viết thất bại',
            'data' => $model->getErrors(),
        ];
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Kiểm tra quyền
        $currentUser = Yii::$app->user->identity;
        $currentRole = $currentUser && $currentUser->jobTitle ? $currentUser->jobTitle->role_code : null;

        if (!in_array($currentRole, ['manager', 'super_admin'])) {
            throw new ForbiddenHttpException('Bạn không có quyền ẩn bài viết này.');
        }

        $model->is_active = 0;
        $model->updated_at = date('Y-m-d H:i:s');

        if ($model->save(false)) {
            return [
                'status' => true,
                'msg' => 'Ẩn bài viết thành công',
                'data' => null,
            ];
        }

        return [
            'status' => false,
            'msg' => 'Ẩn bài viết thất bại',
            'data' => $model->getErrors(),
        ];
    }
}
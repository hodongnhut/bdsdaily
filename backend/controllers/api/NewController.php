<?php

namespace backend\controllers\api;

use Yii;

use yii\rest\Controller;
use common\models\NewsExtranaly as TblNews;
use common\models\SeoTopics;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;

class NewController extends Controller
{

    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'index' => ['GET'],
            'view' => ['GET'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['POST'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        // Optional: Add authentication if needed
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['index', 'view'], // Public actions
        ];
        return $behaviors;
    }

    /**
     * Disables CSRF validation for the actionUpdateStatus method.
     */
    public function beforeAction($action)
    {
        if (in_array($action->id, ['index', 'update-status', 'view', 'create'])) {
            Yii::$app->controller->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $topics = SeoTopics::find()->where(['status' => 0])->limit(5)->all();

        Yii::error('Returned Topics: ' . print_r($topics, true), __METHOD__);
        return $topics;
    }

    public function actionUpdateStatus($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $topic = SeoTopics::findOne($id);

        if ($topic === null) {
            throw new NotFoundHttpException('Topic not found');
        }

        $topic->status = 1;

        if ($topic->save()) {
            return [
                'status' => 'success',
                'message' => 'Status updated to 1',
                'data' => $topic
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Failed to update status'
            ];
        }
    }

    public function actionView($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $topic = SeoTopics::findOne($id);

        if ($topic === null) {
            throw new NotFoundHttpException('Topic not found');
        }

        return [
            'status' => 'success',
            'data' => $topic
        ];
    }

    public function actionCreate()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new TblNews();

        $rawBody = Yii::$app->request->getRawBody();
        $data = json_decode($rawBody, true);
    
        if ($model->load($data, '') && $model->validate()) {
            if ($model->save()) {
                return [
                    'status' => 'success',
                    'message' => 'News created successfully',
                    'news' => $model,
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Failed to create News',
                    'errors' => $model->errors,
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Invalid data',
                'errors' => $model->errors,
            ];
        }
    }

}

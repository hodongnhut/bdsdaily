<?php
namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use common\models\NewsExtranaly as News;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
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
            'delete' => ['DELETE'],
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
     * Lists all news items.
     * @return array
     */
    public function actionIndex()
    {
        $news = News::find()->all();
        return [
            'status' => 'success',
            'data' => $news,
        ];
    }

    /**
     * Displays a single news item by ID.
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $news = $this->findModel($id);
        return [
            'status' => 'success',
            'data' => $news,
        ];
    }

    /**
     * Creates a new news item.
     * @return array
     */
    public function actionCreate()
    {
        $model = new News();
        $model->load(Yii::$app->request->post(), '');
        
        if ($model->save()) {
            Yii::$app->response->setStatusCode(201); // Created
            return [
                'status' => 'success',
                'data' => $model,
            ];
        } else {
            Yii::$app->response->setStatusCode(422); // Unprocessable Entity
            return [
                'status' => 'error',
                'errors' => $model->errors,
            ];
        }
    }

    /**
     * Updates an existing news item by ID.
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post(), '');
        
        if ($model->save()) {
            return [
                'status' => 'success',
                'data' => $model,
            ];
        } else {
            Yii::$app->response->setStatusCode(422);
            return [
                'status' => 'error',
                'errors' => $model->errors,
            ];
        }
    }

    /**
     * Deletes a news item by ID.
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        
        return [
            'status' => 'success',
            'message' => 'News item deleted successfully.',
        ];
    }

    /**
     * Finds the News model by ID.
     * @param int $id
     * @return News
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested news item does not exist.');
    }
}
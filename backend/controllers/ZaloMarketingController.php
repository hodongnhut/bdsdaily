<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl; 
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use common\models\ZaloContact;
use common\models\ZaloContactSearch;

class ZaloMarketingController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'except' => ['list', 'update-zalo'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], 
                        'matchCallback' => function ($rule, $action) {
                            $user = Yii::$app->user;
                            $identity = $user->identity;
                            
                            if (isset($identity->jobTitle->role_code)) {
                                return in_array($identity->jobTitle->role_code, ['manager', 'super_admin']);
                            }
                            return false;
                        }
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
    /**
     * Lists all ZaloContact models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ZaloContactSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $models = ZaloContact::find()
        ->select(['id', 'zalo', 'phone', 'status'])
        ->where(['status' => '0'])
        ->limit(10)
        ->all();

        return [
            'success' => true,
            'count' => count($models),
            'data' => $models,
        ];
    }

    public function actionUpdateZalo($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        $model = $this->findModel($id);
    
        if (!$model) {
            return [
                'success' => false,
                'message' => 'Record not found.',
            ];
        }
    
        $request = Yii::$app->request;
    
        if ($request->isPost) {
            $data = $request->post();
    
            if ($model->load($data, '') && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'Zalo contact updated successfully.',
                    'data' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to update.',
                    'errors' => $model->getErrors(),
                ];
            }
        }
    
        return [
            'success' => false,
            'message' => 'Invalid request method.',
        ];
    }
    

    /**
     * Displays a single ZaloContact model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ZaloContact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ZaloContact();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ZaloContact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ZaloContact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ZaloContact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return ZaloContact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ZaloContact::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
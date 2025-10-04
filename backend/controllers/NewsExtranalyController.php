<?php

namespace backend\controllers;

use common\models\NewsExtranaly;
use common\models\NewsExtranalySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsExtranalyController implements the CRUD actions for NewsExtranaly model.
 */
class NewsExtranalyController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all NewsExtranaly models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new NewsExtranalySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $chartData = $this->getChartData(); 

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'chartData' => $chartData,
        ]);
    }

    /**
     * Lấy dữ liệu thống kê số lượng bài viết được tạo trong 7 ngày gần nhất.
     * @return array
     */
    protected function getChartData()
    {
        // 1. Tính toán ngày bắt đầu (7 ngày trước, tính từ 00:00:00)
        $sevenDaysAgo = date('Y-m-d 00:00:00', strtotime('-7 days'));
        
        // 2. Truy vấn dữ liệu: gom nhóm theo ngày
        // Giả định cột created_at là kiểu DATETIME/TIMESTAMP (dựa trên Model rules())
        $queryData = NewsExtranaly::find()
            ->select([
                'log_date' => new \yii\db\Expression('DATE(created_at)'),
                'count' => new \yii\db\Expression('COUNT(*)'),
            ])
            ->where(['>=', 'created_at', $sevenDaysAgo])
            ->groupBy(['log_date'])
            ->asArray()
            ->all();

        $allDates = [];

        // Khởi tạo 7 ngày gần nhất với số lượng bài viết = 0
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $allDates[$date] = 0;
        }

        // Điền dữ liệu đã query vào mảng
        foreach ($queryData as $row) {
            $date = $row['log_date'];
            $count = (int) $row['count'];
            
            if (isset($allDates[$date])) {
                $allDates[$date] = $count;
            }
        }

        // Định dạng dữ liệu cuối cùng
        $chartData = [
            'labels' => array_keys($allDates),
            'postCounts' => array_values($allDates), // Lấy mảng số lượng bài viết
        ];
        
        // Chuyển định dạng ngày Y-m-d thành d/m (ví dụ: 01/10) cho dễ nhìn
        $chartData['labels'] = array_map(function($date) {
            return date('d/m', strtotime($date));
        }, $chartData['labels']);

        return $chartData;
    }

    

    /**
     * Displays a single NewsExtranaly model.
     * @param int $id ID
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
     * Creates a new NewsExtranaly model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new NewsExtranaly();

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
     * Updates an existing NewsExtranaly model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
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
     * Deletes an existing NewsExtranaly model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the NewsExtranaly model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return NewsExtranaly the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NewsExtranaly::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

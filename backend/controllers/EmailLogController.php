<?php

namespace backend\controllers;

use common\models\EmailLog;
use common\models\EmailLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmailLogController implements the CRUD actions for EmailLog model.
 */
class EmailLogController extends Controller
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
     * Lists all EmailLog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EmailLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $chartData = $this->getChartData(); 

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'chartData' => $chartData,
        ]);
    }

    /**
     * Lấy dữ liệu thống kê email thành công/thất bại trong 7 ngày gần nhất.
     * @return array
     */
    protected function getChartData()
    {
        // 1. Tính toán ngày bắt đầu (7 ngày trước, tính từ 00:00:00)
        $sevenDaysAgo = strtotime('-7 days midnight');

        // 2. Truy vấn dữ liệu: gom nhóm theo ngày và trạng thái
        $queryData = EmailLog::find()
            ->select([
                'log_date' => new \yii\db\Expression('DATE(sent_at)'),
                'status',
                'count' => new \yii\db\Expression('COUNT(*)'),
            ])
            ->where(['>=', 'sent_at', $sevenDaysAgo])
            ->groupBy(['log_date', 'status'])
            ->asArray()
            ->all();

        $allDates = [];

        // Khởi tạo 7 ngày gần nhất
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $allDates[$date] = [
                'success' => 0,
                'failure' => 0,
            ];
        }

        // Điền dữ liệu đã query vào mảng
        foreach ($queryData as $row) {
            $date = $row['log_date'];
            $status = strtolower($row['status']); 
            $count = (int) $row['count'];

            if (isset($allDates[$date])) {
                // Giả định trạng thái thành công là 'sent' hoặc 'success'
                if ($status === 'sent' || $status === 'success') { 
                    $allDates[$date]['success'] += $count;
                } 
                // Giả định trạng thái thất bại là 'failed' hoặc 'error'
                else if ($status === 'failed' || $status === 'error') { 
                    $allDates[$date]['failure'] += $count;
                }
            }
        }

        // Định dạng dữ liệu cuối cùng
        $chartData = [
            'labels' => array_keys($allDates),
            'successData' => array_column($allDates, 'success'),
            'failureData' => array_column($allDates, 'failure'),
        ];
        
        // Chuyển định dạng ngày Y-m-d thành d/m (ví dụ: 01/10) cho dễ nhìn
        $chartData['labels'] = array_map(function($date) {
            return date('d/m', strtotime($date));
        }, $chartData['labels']);

        return $chartData;
    }

    /**
     * Displays a single EmailLog model.
     * @param int $id
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
     * Creates a new EmailLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new EmailLog();

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
     * Updates an existing EmailLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
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
     * Deletes an existing EmailLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EmailLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return EmailLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmailLog::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

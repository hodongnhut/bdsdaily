<?php

namespace backend\controllers;

use Yii;
use common\models\MailerConfig;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl; 


class MailerController extends Controller
{
        /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $user = Yii::$app->user;
                            $identity = $user->identity;
                            
                            if (isset($identity->jobTitle->role_code)) {
                                return in_array($identity->jobTitle->role_code, ['super_admin']);
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

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MailerConfig::find()->orderBy(['priority' => SORT_DESC]),
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate()
    {
        $model = new MailerConfig();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionTest($id)
    {
        $config = $this->findModel($id);

        try {
            $transportConfig = $config->getTransportConfig();
            $dsn = $transportConfig['dsn'] ?? \Symfony\Component\Mailer\Transport::fromDsnArray($transportConfig);

            $mailer = new \yii\symfonymailer\Mailer();
            $mailer->setTransport(\Symfony\Component\Mailer\Transport::fromDsn($dsn));

            $mailer->compose()
                ->setFrom('nhuthd@bdsdaily.com')
                ->setTo('hodongnhut@gmail.com')
                ->setSubject('Test Mail từ ' . $config->name)
                ->setTextBody('Nếu bạn nhận được mail này → Config hoạt động hoàn hảo!')
                ->send();

            Yii::$app->session->setFlash('success', "Test thành công với {$config->name}!");
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'Lỗi: ' . $e->getMessage());
        }

        return $this->redirect(['update', 'id' => $id]);
    }

    protected function findModel($id)
    {
        if (($model = MailerConfig::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Không tìm thấy.');
    }
}
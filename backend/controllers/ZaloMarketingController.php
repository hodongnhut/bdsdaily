<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl; 
use yii\filters\VerbFilter;
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
    public function actionIndex()
    {
        return $this->render('index');
    }
}
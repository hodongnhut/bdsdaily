<?php

namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use common\models\NewsExtranaly as News;
class NewController extends Controller
{
    public $enableCsrfValidation = false;

    protected function verbs()
    {
        return [
            'index' => ['GET'],
            'create' => ['POST'],
            'view' => ['GET'],
            'update' => ['PUT', 'PATCH'],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        return $behaviors;
    }
}
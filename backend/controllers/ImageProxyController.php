<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\httpclient\Client;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ImageProxyController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'load' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Proxy tải ảnh từ https://kinglandgroup.vn (có cache nội bộ)
     * @param string $path Đường dẫn ảnh (tương đối)
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionLoad($path)
    {
        $baseUrl = 'https://kinglandgroup.vn';

        $filePath = $baseUrl . '/' . $path;

        if (!file_exists($filePath)) {
            Yii::error("File not found: $filePath", __METHOD__);
            throw new NotFoundHttpException('Image not found.');
        }

        header('Content-Type: image/jpeg');
        readfile($filePath);
        Yii::$app->end();
    }
}

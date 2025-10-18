<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\httpclient\Client;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ImageProxyController handles proxying and caching of external images.
 * Currently configured to proxy images from 'https://kinglandgroup.vn'.
 * The rule 'image-proxy/<path:.+>' => 'image-proxy/load' is assumed.
 */
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

    public $enableCsrfValidation = false;

    public function actionLoad($path)
    {
        // Domain gốc bạn muốn ẩn
        $baseUrl = 'https://kinglandgroup.vn/';

        // Tạo URL hoàn chỉnh
        $url = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');

        // Tải ảnh
        $client = new \yii\httpclient\Client(['transport' => 'yii\httpclient\StreamTransport']);
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->addHeaders([
                'Origin' => 'kinglandgroup.vn', 
            ])
            ->send();

        if (!$response->isOk) {
            throw new NotFoundHttpException('Không tìm thấy hình ảnh');
        }


        // Trả về ảnh trực tiếp
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', $response->headers->get('content-type', 'image/jpeg'));
        Yii::$app->response->headers->set('Cache-Control', 'max-age=86400');
        
        return $response->content;
    }
}

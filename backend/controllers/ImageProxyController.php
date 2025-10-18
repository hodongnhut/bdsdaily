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
        $baseUrl = 'https://kinglandgroup.vn';

        // Tạo URL hoàn chỉnh
        $url = $baseUrl . ltrim($path, '/');

        // Tải ảnh
        $client = new Client();
        $response = $client->get($url)->send();

        if (!$response->isOk) {
            throw new NotFoundHttpException('Không tìm thấy hình ảnh');
        }

        // Lấy header content-type (image/jpeg, image/png, ...)
        $contentType = $response->headers->get('content-type', 'image/jpeg');

        // Trả về ảnh trực tiếp
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', $contentType);
        Yii::$app->response->headers->set('Cache-Control', 'max-age=86400'); // cache 1 ngày

        return $response->content;
    }
}

<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\httpclient\Client;

class ImageProxyController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionLoad($path)
    {
        $baseUrl = 'https://kinglandgroup.vn/';
        $url = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');

        $client = new \yii\httpclient\Client(['transport' => 'yii\httpclient\StreamTransport']);

        $response = $client->createRequest()
            ->setUrl($url)
            ->setOptions(['sslVerifyPeer' => false, 'sslVerifyHost' => false]) // Bỏ kiểm tra SSL
            ->send();

        if (!$response->isOk) {
            Yii::error("Không tải được ảnh từ: $url", __METHOD__);
            throw new \yii\web\NotFoundHttpException('Không tìm thấy hình ảnh');
        }

        $mimeType = $response->headers->get('content-type', 'image/jpeg');

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', $mimeType);
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', '*');
        Yii::$app->response->content = $response->content;

        // Xóa mọi buffer nếu có
        if (ob_get_length()) {
            ob_clean();
        }
        flush();

        return Yii::$app->response;
    }
}

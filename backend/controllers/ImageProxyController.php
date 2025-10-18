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

        $client = new Client(['transport' => 'yii\httpclient\StreamTransport']);

        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->addHeaders([
                'Origin' => Yii::$app->request->hostInfo,
            ])
            ->send();

        if (!$response->isOk) {
            throw new NotFoundHttpException('Không tìm thấy hình ảnh.');
        }

        // Lấy MIME type (VD: image/jpeg, image/png, ...)
        $mimeType = $response->headers->get('content-type', 'image/jpeg');
        $base64 = base64_encode($response->content);
        return "data:$mimeType;base64,$base64";
    }
}

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
        $response = $client->get($url)->send();

        if (!$response->isOk) {
            throw new \yii\web\NotFoundHttpException('Không tìm thấy hình ảnh');
        }

        // Lấy kiểu MIME (jpeg/png/...)
        $mimeType = $response->headers->get('content-type', 'image/jpeg');

        // Encode Base64 → decode lại để trả về dữ liệu ảnh thật
        $base64 = base64_encode($response->content);
        $imageData = base64_decode($base64);

        // Trả về dạng ảnh (chứ không HTML)
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', $mimeType);
        Yii::$app->response->headers->set('Cache-Control', 'max-age=86400');

        return $imageData;
    }
}

<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\httpclient\Client;

class MapController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionProxy($path)
    {
        $baseUrl = "https://files.rockervietnam.com/ZoningMapVer2/";

        // Nối đường dẫn request vào baseUrl
        $url = $baseUrl . $path;

        $client = new Client([
            'transport' => 'yii\httpclient\CurlTransport' // dùng Curl cho ổn định
        ]);

        try {
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl($url)
                ->send();

            if ($response->isOk) {
                // Trả về raw content, giữ nguyên content-type gốc
                Yii::$app->response->format = Response::FORMAT_RAW;
                Yii::$app->response->headers->set('Content-Type', $response->headers['content-type'] ?? 'application/octet-stream');

                return $response->content;
            } else {
                Yii::$app->response->statusCode = $response->statusCode;
                return "Upstream error: {$response->statusCode}";
            }
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            return "Proxy error: " . $e->getMessage();
        }
    }
}

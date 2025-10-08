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
        $baseUrl = "https://app.tapdoantoancau.com/ZoningMapVer2/";

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

   
    /**
     * Proxy fonts request để ẩn domain demotiles.maplibre.org
     * Cache lại file trong 1 ngày để tránh request lặp
     */
    public function actionFonts($fontstack, $range)
    {
        $baseUrl = "https://demotiles.maplibre.org/font/";

        // Encode lại fontstack (vd: "Noto Sans Regular" → "Noto%20Sans%20Regular")
        $encodedFontstack = rawurlencode($fontstack);
        $url = "{$baseUrl}{$encodedFontstack}/{$range}.pbf";

        // 🔹 Tạo cache key riêng cho mỗi fontstack + range
        $cacheKey = "map_font_{$fontstack}_{$range}";

        // 🔹 Kiểm tra xem đã có cache chưa
        $cached = Yii::$app->cache->get($cacheKey);
        if ($cached !== false) {
            Yii::$app->response->format = Response::FORMAT_RAW;
            Yii::$app->response->headers->set('Content-Type', 'application/x-protobuf');
            return $cached;
        }

        // 🔹 Nếu chưa có cache, tải từ upstream
        $client = new Client([
            'transport' => 'yii\httpclient\CurlTransport',
        ]);

        try {
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl($url)
                ->send();

            if ($response->isOk) {
                $content = $response->content;

                // Lưu cache 1 ngày (86400 giây)
                Yii::$app->cache->set($cacheKey, $content, 86400);

                Yii::$app->response->format = Response::FORMAT_RAW;
                Yii::$app->response->headers->set(
                    'Content-Type',
                    $response->headers['content-type'] ?? 'application/x-protobuf'
                );

                return $content;
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

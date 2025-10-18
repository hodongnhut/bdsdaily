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

        // Kiểm tra path hợp lệ (chặn directory traversal)
        if (preg_match('/\.\.\//', $path)) {
            throw new NotFoundHttpException('Invalid image path.');
        }

        // Chỉ cho phép định dạng ảnh thông dụng
        if (!preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $path)) {
            throw new NotFoundHttpException('Invalid image type.');
        }

        // Tạo URL đầy đủ
        $imageUrl = strpos($path, '/') === 0 ? $baseUrl . $path : $baseUrl . '/' . $path;

        // Tạo đường dẫn cache nội bộ
        $cacheDir = Yii::getAlias('@runtime/image-cache');
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }
        $cachePath = $cacheDir . '/' . md5($path) . '.' . pathinfo($path, PATHINFO_EXTENSION);

        // Nếu đã cache, trả ngay ảnh ra
        if (file_exists($cachePath)) {
            return Yii::$app->response->sendFile($cachePath, null, ['inline' => true]);
        }

        // Dùng HTTP client tải ảnh
        $client = new Client(['transport' => 'yii\httpclient\CurlTransport']);
        try {
            Yii::info("Loading image from: " . $imageUrl, __METHOD__);
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl($imageUrl)
                ->send();

            Yii::info("HTTP Status: " . $response->statusCode, __METHOD__);
            if ($response->isOk) {
                $content = $response->content;

                // Giới hạn kích thước ảnh tối đa (10MB)
                if (strlen($content) > 10 * 1024 * 1024) {
                    throw new NotFoundHttpException('Image too large.');
                }

                // Lưu cache nội bộ
                file_put_contents($cachePath, $content);

                // Gửi ảnh ra trình duyệt
                $contentType = $response->headers->get('content-type', 'image/jpeg');
                $yiiResponse = Yii::$app->response;
                $yiiResponse->format = Response::FORMAT_RAW;
                $yiiResponse->headers->set('Content-Type', $contentType);
                $yiiResponse->headers->set('Cache-Control', 'public, max-age=86400'); // cache 1 ngày
                $yiiResponse->headers->set('Content-Length', strlen($content));

                return $content;
            } else {
                Yii::error("Remote image not OK: " . $response->statusCode, __METHOD__);
                throw new NotFoundHttpException('Image not found or inaccessible.');
            }
        } catch (\Exception $e) {
            Yii::error('ImageProxy Error: ' . $e->getMessage(), __METHOD__);
            throw new NotFoundHttpException('Failed to load image.');
        }
    }
}

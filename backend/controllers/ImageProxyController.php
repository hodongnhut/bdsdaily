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

    /**
     * Proxy tải ảnh từ https://kinglandgroup.vn (có cache nội bộ)
     * @param string $path Đường dẫn ảnh (tương đối) từ thư mục gốc của domain.
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionLoad($path)
    {
        // Set necessary headers before Yii's response processing starts,
        // especially for CORS and content type fallback.
        header('Access-Control-Allow-Origin: *'); // Allow all domains to access the image
        header('Content-Type: image/jpeg'); // Fallback content type

        // --- Configuration ---
        // Target base domain for the proxy
        $baseUrl = 'https://kinglandgroup.vn';
        
        // Allowed domains/base URLs (for security, prevent arbitrary proxying)
        // Note: For this setup, we hardcode the target, so this is just for reference.
        // If you need multiple, you'd check $path for a domain prefix here.
        $allowedTargetDomain = 'kinglandgroup.vn';
        // ---------------------

        // 1. Kiểm tra path hợp lệ (chặn directory traversal: ../)
        if (preg_match('/\.\.\//', $path)) {
            throw new NotFoundHttpException('Invalid image path (directory traversal attempt detected).');
        }

        // 2. Chỉ cho phép định dạng ảnh thông dụng
        if (!preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $path)) {
            throw new NotFoundHttpException('Invalid image type. Only JPG, PNG, GIF, and WEBP are allowed.');
        }

        // 3. Tạo URL đầy đủ (đảm bảo path bắt đầu bằng / nếu cần)
        $normalizedPath = ltrim($path, '/');
        $imageUrl = $baseUrl . '/' . $normalizedPath;

        // 4. Tạo đường dẫn cache nội bộ
        $cacheDir = Yii::getAlias('@runtime/image-cache');
        if (!is_dir($cacheDir)) {
            // Suppress error reporting to avoid revealing server paths if mkdir fails
            @mkdir($cacheDir, 0777, true);
        }
        
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $cachePath = $cacheDir . '/' . md5($imageUrl) . '.' . $extension; // Use $imageUrl for md5 to be more precise

        // 5. Nếu đã cache, trả ngay ảnh ra
        if (file_exists($cachePath)) {
            Yii::info("Serving image from cache: " . $cachePath, __METHOD__);
            return Yii::$app->response->sendFile($cachePath, null, [
                'inline' => true,
                'mimeType' => mime_content_type($cachePath) ?: 'image/jpeg',
                'cacheControl' => 'public, max-age=86400',
            ]);
        }

        // 6. Dùng HTTP client tải ảnh
        $client = new Client(['transport' => 'yii\httpclient\CurlTransport']);
        try {
            Yii::info("Loading image from: " . $imageUrl, __METHOD__);
            
            // Set reasonable timeout for external requests
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl($imageUrl)
                ->setOptions([
                    CURLOPT_TIMEOUT => 30, // 30 seconds timeout
                ])
                ->send();

            Yii::info("HTTP Status: " . $response->statusCode, __METHOD__);
            if ($response->isOk) {
                $content = $response->content;
                $contentLength = strlen($content);

                // Giới hạn kích thước ảnh tối đa (10MB)
                if ($contentLength > 10 * 1024 * 1024) {
                    throw new NotFoundHttpException('Image too large (max 10MB).');
                }

                // Lưu cache nội bộ
                file_put_contents($cachePath, $content);

                // 7. Gửi ảnh ra trình duyệt
                $contentType = $response->headers->get('content-type', 'image/jpeg');
                $yiiResponse = Yii::$app->response;
                $yiiResponse->format = Response::FORMAT_RAW;
                $yiiResponse->headers->set('Content-Type', $contentType);
                $yiiResponse->headers->set('Cache-Control', 'public, max-age=86400'); // Cache 1 ngày
                $yiiResponse->headers->set('Content-Length', $contentLength);
                
                // Set the raw content to be returned
                return $content;
            } else {
                Yii::error("Remote image not OK. Status: " . $response->statusCode . " URL: " . $imageUrl, __METHOD__);
                throw new NotFoundHttpException('Image not found or inaccessible on the remote server.');
            }
        } catch (\Exception $e) {
            Yii::error('ImageProxy Error: ' . $e->getMessage() . " for URL: " . $imageUrl, __METHOD__);
            throw new NotFoundHttpException('Failed to load image due to a proxy error.');
        }
    }
}

<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\log\Logger;

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
     * Loads an image from https://kinglandgroup.vn using cURL.
     * @param string $path The image path (relative to base URL)
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionLoad($path)
    {
        // Define base URL
        $baseUrl = 'https://kinglandgroup.vn';

        // Decode URL-encoded path
        $decodedPath = urldecode($path);

        // Construct full image URL
        $imageUrl = strpos($decodedPath, '/') === 0 ? $baseUrl . $decodedPath : $baseUrl . '/' . $decodedPath;

        // Validate path to prevent directory traversal and allow specific image formats
        if (preg_match('/\.\.\//', $decodedPath) || !preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $decodedPath)) {
            Yii::getLogger()->log('Invalid image path: ' . $decodedPath, Logger::LEVEL_ERROR, 'image-proxy');
            throw new NotFoundHttpException('Invalid image path.');
        }

        // Function to fetch image with cURL
        $fetchImage = function ($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_USERAGENT, 'BdsDaily/1.0 (PHP/' . PHP_VERSION . ')');

            $response = curl_exec($ch);
            $error = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $body = $response !== false ? substr($response, $headerSize) : '';

            curl_close($ch);

            return [
                'success' => $response !== false && !$error && $httpCode === 200 && !empty($body),
                'body' => $body,
                'contentType' => $contentType,
                'httpCode' => $httpCode,
                'error' => $error,
            ];
        };

        // Try primary image
        $result = $fetchImage($imageUrl);
        $logUrl = $imageUrl;

        // Try WebP fallback if initial request fails and path is not already WebP
        if (!$result['success'] && preg_match('/\.(jpg|jpeg|png|gif)$/i', $decodedPath)) {
            $webpPath = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '.webp', $decodedPath);
            $webpUrl = strpos($webpPath, '/') === 0 ? $baseUrl . $webpPath : $baseUrl . '/' . $webpPath;
            Yii::getLogger()->log('Trying WebP fallback: ' . $webpUrl, Logger::LEVEL_INFO, 'image-proxy');
            $result = $fetchImage($webpUrl);
            $logUrl = $webpUrl;
        }

        if ($result['success']) {
            // Validate content
            if (empty($result['body']) || strlen($result['body']) < 100) {
                // Adjust threshold based on expected minimum image size
                Yii::getLogger()->log('Invalid or empty image content: ' . $logUrl . ' [Size: ' . strlen($result['body']) . ' bytes]', Logger::LEVEL_ERROR, 'image-proxy');
                throw new NotFoundHttpException('Image content is invalid or empty.');
            }

            // Set default content type if not provided
            $contentType = $result['contentType'] ?: 'image/webp';

            // Set response headers
            $yiiResponse = Yii::$app->response;
            $yiiResponse->format = Response::FORMAT_RAW;
            $yiiResponse->headers->add('Content-Type', $contentType);
            $yiiResponse->headers->add('Cache-Control', 'public, max-age=86400');
            $yiiResponse->headers->add('Content-Length', strlen($result['body']));

            return $result['body'];
        } else {
            $errorMsg = $result['error'] ?: 'HTTP Code: ' . $result['httpCode'];
            Yii::getLogger()->log('Failed to fetch image: ' . $logUrl . ' - ' . $errorMsg . ' [Server: ' . php_uname('n') . ', PHP: ' . PHP_VERSION . ', cURL: ' . curl_version()['version'] . ']', Logger::LEVEL_ERROR, 'image-proxy');
            throw new NotFoundHttpException('Failed to load image: ' . $errorMsg);
        }
    }
}
?>
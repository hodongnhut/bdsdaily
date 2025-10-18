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

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $imageUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 10-second timeout
        curl_setopt($ch, CURLOPT_HEADER, true); // Include headers in output
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Verify SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // Verify hostname

        // Execute cURL request
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        if ($response === false || $error) {
            curl_close($ch);
            Yii::getLogger()->log('cURL error for ' . $imageUrl . ': ' . $error . ' [Server: ' . php_uname('n') . ', PHP: ' . PHP_VERSION . ']', Logger::LEVEL_ERROR, 'image-proxy');
            throw new NotFoundHttpException('Failed to load image: ' . $error);
        }

        // Extract headers and body
        $headers = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        // Try WebP fallback if initial request fails and path is not already WebP
        if ($httpCode !== 200 && preg_match('/\.(jpg|jpeg|png|gif)$/i', $decodedPath)) {
            curl_close($ch);
            $webpPath = preg_replace('/\.(jpg|jpeg|png|gif)$/i', '.webp', $decodedPath);
            $webpUrl = strpos($webpPath, '/') === 0 ? $baseUrl . $webpPath : $baseUrl . '/' . $webpPath;
            Yii::getLogger()->log('Trying WebP fallback: ' . $webpUrl, Logger::LEVEL_INFO, 'image-proxy');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $webpUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

            $response = curl_exec($ch);
            $error = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $body = substr($response, $headerSize);

            if ($response === false || $error) {
                curl_close($ch);
                Yii::getLogger()->log('cURL error for WebP fallback ' . $webpUrl . ': ' . $error . ' [Server: ' . php_uname('n') . ', PHP: ' . PHP_VERSION . ']', Logger::LEVEL_ERROR, 'image-proxy');
                throw new NotFoundHttpException('Failed to load WebP image: ' . $error);
            }
        }

        curl_close($ch);

        if ($httpCode === 200) {
            // Set default content type if not provided
            $contentType = $contentType ?: 'image/webp';

            // Set response headers
            $yiiResponse = Yii::$app->response;
            $yiiResponse->format = Response::FORMAT_RAW;
            $yiiResponse->headers->add('Content-Type', $contentType);
            $yiiResponse->headers->add('Cache-Control', 'public, max-age=86400');
            $yiiResponse->headers->add('Content-Length', strlen($body));

            return $body;
        } else {
            Yii::getLogger()->log('Failed to fetch image: ' . $imageUrl . ' (HTTP Code: ' . $httpCode . ')', Logger::LEVEL_ERROR, 'image-proxy');
            throw new NotFoundHttpException('Image not found or inaccessible (HTTP Code: ' . $httpCode . ').');
        }
    }
}
?>
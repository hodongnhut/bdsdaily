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
 * This controller has been updated to use modern Yii2 practices for response
 * and header management, and includes a common HTTP client option for handling redirects.
 *
 * The rule 'image-proxy/<path:.+>' => 'image-proxy/load' is assumed.
 */
class ImageProxyController extends Controller
{
    /**
     * @var string The target base domain for the proxy.
     */
    private $targetBaseUrl = 'https://kinglandgroup.vn';

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
     * Proxy tải ảnh từ domain ngoài (có cache nội bộ).
     *
     * @param string $path Đường dẫn ảnh (tương đối) từ thư mục gốc của domain.
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionLoad($path)
    {
        $response = Yii::$app->response;
        // Ensure raw format for binary image data
        $response->format = Response::FORMAT_RAW; 

        // 1. Set common headers for the response using the Yii Response object
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Cache-Control', 'public, max-age=86400'); // Cache 1 ngày

        // 2. Security Checks
        if (preg_match('/\.\.\//', $path)) {
            Yii::warning('ImageProxy: Directory traversal attempt detected for path: ' . $path, __METHOD__);
            throw new NotFoundHttpException('Invalid image path.');
        }

        // Only allow common image formats (case-insensitive)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (!in_array(strtolower($extension), $allowedExtensions)) {
            Yii::warning('ImageProxy: Invalid image type requested: ' . $path, __METHOD__);
            throw new NotFoundHttpException('Invalid image type. Only ' . strtoupper(implode(', ', $allowedExtensions)) . ' are allowed.');
        }

        // 3. Construct URL and Cache Paths
        $normalizedPath = ltrim($path, '/');
        $imageUrl = $this->targetBaseUrl . '/' . $normalizedPath;

        $cacheDir = Yii::getAlias('@runtime/image-cache');
        if (!is_dir($cacheDir)) {
            // Suppress errors and check existence to handle race conditions safely
            if (!@mkdir($cacheDir, 0777, true) && !is_dir($cacheDir)) {
                Yii::error('ImageProxy: Failed to create cache directory: ' . $cacheDir, __METHOD__);
                // Script will continue without caching if directory creation fails
            }
        }
        
        $cachePath = $cacheDir . '/' . md5($imageUrl) . '.' . $extension;

        // 4. Cache Hit: Serve from internal cache
        if (file_exists($cachePath)) {
            Yii::info("Serving image from cache: " . $cachePath, __METHOD__);
            
            // Determine MIME type for correct serving
            $mimeType = @mime_content_type($cachePath) ?: ('image/' . strtolower($extension));

            // Use Yii's response->sendFile for efficient file serving
            return $response->sendFile($cachePath, null, [
                'inline' => true,
                'mimeType' => $mimeType,
                'cacheControl' => 'public, max-age=86400', 
            ]);
        }

        // 5. Cache Miss: Download the image
        $client = new Client(['transport' => 'yii\httpclient\CurlTransport']);
        try {
            Yii::info("Loading image from remote URL: " . $imageUrl, __METHOD__);
            
            // Set options including follow location (important for redirects)
            $remoteResponse = $client->createRequest()
                ->setMethod('GET')
                ->setUrl($imageUrl)
                ->setOptions([
                    CURLOPT_TIMEOUT => 30, // 30 seconds timeout
                    CURLOPT_FOLLOWLOCATION => true, // Handle redirects (modernization)
                ])
                ->send();

            if (!$remoteResponse->isOk) {
                Yii::error("Remote image not OK. Status: " . $remoteResponse->statusCode . " URL: " . $imageUrl, __METHOD__);
                throw new NotFoundHttpException('Image not found or inaccessible on the remote server. Status: ' . $remoteResponse->statusCode);
            }

            $content = $remoteResponse->content;
            $contentLength = strlen($content);
            $contentType = $remoteResponse->headers->get('content-type', 'image/jpeg');

            // 6. Size Check & Content Validation
            $maxSize = 10 * 1024 * 1024; // 10MB
            if ($contentLength > $maxSize) {
                Yii::warning("Image is too large: " . $contentLength . " bytes for URL: " . $imageUrl, __METHOD__);
                throw new NotFoundHttpException('Image too large (max 10MB).');
            }
            
            // Tighter Content-Type check against response header
            if (!preg_match('/^image\/(jpg|jpeg|png|gif|webp)/i', $contentType)) {
                 Yii::warning("Image has invalid remote Content-Type: " . $contentType . " for URL: " . $imageUrl, __METHOD__);
                 throw new NotFoundHttpException('Remote content is not a valid image type.');
            }


            // 7. Save cache and send response
            if (is_dir($cacheDir)) {
                file_put_contents($cachePath, $content);
                Yii::info("Image cached successfully: " . $cachePath, __METHOD__);
            }
            
            // Finalize Response Headers
            $response->headers->set('Content-Type', $contentType);
            $response->headers->set('Content-Length', $contentLength);
            
            // Set the raw content and return the response object
            $response->content = $content;
            return $response;

        } catch (NotFoundHttpException $e) {
            // Re-throw 404s
            throw $e;
        } catch (\Exception $e) {
            Yii::error('ImageProxy Error: ' . $e->getMessage() . " for URL: " . $imageUrl, __METHOD__);
            throw new NotFoundHttpException('Failed to load image due in the proxy system.');
        }
    }
}

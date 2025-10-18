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

    private $cachePath;

    public function init()
    {
        parent::init();
        // --- 2. Check Server File Permissions: Ensure write access to this path ---
        // This MUST be writable by the web server user (Apache/Nginx)
        $this->cachePath = Yii::getAlias('@runtime/image-cache');

        if (!is_dir($this->cachePath)) {
            // Attempt to create the directory if it doesn't exist
            if (!mkdir($this->cachePath, 0775, true) && !is_dir($this->cachePath)) {
                // Log and throw an error if directory creation fails
                Yii::error("Failed to create image cache directory: " . $this->cachePath, 'image-proxy');
                // Note: You can't safely throw an exception here without affecting the whole app
            }
        }
    }


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
        // 1. Determine the source URL and target cache file
        $baseUrl = 'https://kinglandgroup.vn/'; // Base URL of the external resource
        $sourceUrl = $baseUrl . $path;

        // Create a unique hash for the cache file name based on the full URL
        $cacheFileName = md5($sourceUrl) . '_' . basename($path);
        $cacheFilePath = $this->cachePath . '/' . $cacheFileName;

        // 2. Check Cache
        if (file_exists($cacheFilePath)) {
            // Cache hit: Serve the cached file
            $mimeType = mime_content_type($cacheFilePath);

            // --- 3. Verify Response Headers: Set Content-Type correctly ---
            return Yii::$app->response->sendFile($cacheFilePath, null, [
                'mimeType' => $mimeType,
                'inline' => true,
            ]);
        }

        // 3. Fetch Remote Image (Cache Miss)
        try {
            $client = new Client();
            // Yii2 HttpClient is safer and better integrated than raw cURL
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl($sourceUrl)
                ->send();

            // --- 1. Check Yii2 Logging for cURL/Fetch Errors: Handle fetch failure ---
            if (!$response->isOk) {
                Yii::error("Failed to fetch image from external source: " . $sourceUrl . " Status: " . $response->getStatusCode(), 'image-proxy-fetch');
                throw new NotFoundHttpException('The requested external image could not be fetched or does not exist.');
            }

            $content = $response->getContent();
            $mimeType = $response->getHeaders()->get('Content-Type');

            // 4. Save to Cache
            if (!empty($content) && str_starts_with($mimeType, 'image/')) {
                // IMPORTANT: Ensure the cache directory is writable!
                if (!file_put_contents($cacheFilePath, $content)) {
                    // Log permission/write failure
                    Yii::error("Failed to write image content to cache file: " . $cacheFilePath, 'image-proxy-permissions');
                    // Continue to serve content directly but log the failure
                }
            } else {
                Yii::warning("Fetched content was not a valid image: " . $sourceUrl . " MIME: " . $mimeType, 'image-proxy-content');
                throw new NotFoundHttpException('Fetched resource was not a valid image.');
            }


            // 5. Serve the new content
            // We use the cached file if the write succeeded, otherwise serve the raw content
            if (file_exists($cacheFilePath)) {
                $mimeType = mime_content_type($cacheFilePath);
                return Yii::$app->response->sendFile($cacheFilePath, null, [
                    'mimeType' => $mimeType,
                    'inline' => true,
                ]);
            } else {
                 // Fallback: Serve content directly if caching failed
                Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
                Yii::$app->response->getHeaders()->set('Content-Type', $mimeType);
                Yii::$app->response->content = $content;
                return Yii::$app->response;
            }


        } catch (\yii\httpclient\Exception $e) {
            // Catch network errors, timeouts, etc.
            Yii::error("Network error during image fetch: " . $e->getMessage() . " URL: " . $sourceUrl, 'image-proxy-network');
            throw new NotFoundHttpException('An internal server error occurred while fetching the image.', 0, $e);
        } catch (\Exception $e) {
            Yii::error("General error in proxy: " . $e->getMessage(), 'image-proxy-general');
            throw new NotFoundHttpException('An internal server error occurred.');
        }
    }
}

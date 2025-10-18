<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\httpclient\Client;
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
     * Loads an image from https://kinglandgroup.vn.
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

        // Validate path to prevent directory traversal and invalid formats
        if (preg_match('/\.\.\//', $path) || !preg_match('/\.(jpg|jpeg|png|gif)$/i', $path)) {
            Yii::getLogger()->log('Invalid image path: ' . $path, Logger::LEVEL_ERROR, 'image-proxy');
            throw new NotFoundHttpException('Invalid image path.');
        }

        // Use HTTP client to fetch the image
        $client = new Client();
        try {
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl($imageUrl)
                ->setOptions([
                    'timeout' => 10, // 10-second timeout
                    'followLocation' => true, // Follow redirects
                ])
                ->send();

            if ($response->isOk) {
                // Get content type from response headers
                $contentType = $response->headers->get('content-type', 'image/jpeg');

                // Set response headers
                $yiiResponse = Yii::$app->response;
                $yiiResponse->format = Response::FORMAT_RAW;
                $yiiResponse->headers->add('Content-Type', $contentType);
                $yiiResponse->headers->add('Cache-Control', 'public, max-age=86400'); // Cache for 1 day
                $yiiResponse->headers->add('Content-Length', strlen($response->content));

                return $response->content;
            } else {
                Yii::getLogger()->log('Failed to fetch image: ' . $imageUrl . ' (Status: ' . $response->statusCode . ')', Logger::LEVEL_ERROR, 'image-proxy');
                throw new NotFoundHttpException('Image not found or inaccessible.');
            }
        } catch (\Exception $e) {
            Yii::getLogger()->log('Failed to load image: ' . $imageUrl . ' - ' . $e->getMessage(), Logger::LEVEL_ERROR, 'image-proxy');
            throw new NotFoundHttpException('Failed to load image: ' . $e->getMessage());
        }
    }
}
?>
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
     * Loads an image from https://kinglandgroup.vn.
     * @param string $path The image path (relative to base URL)
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionLoad($path)
    {
        // Define base URL
        $baseUrl = 'https://kinglandgroup.vn';

        // Construct full image URL
        $imageUrl = strpos($path, '/') === 0 ? $baseUrl . $path : $baseUrl . '/' . $path;

        // Validate path to prevent directory traversal
        if (preg_match('/\.\.\//', $path)) {
            throw new NotFoundHttpException('Invalid image path.');
        }

        // Use HTTP client to fetch the image
        $client = new Client();
        try {
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl($imageUrl)
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

                // Return the image content
                echo $response->content; die;
            } else {
                throw new NotFoundHttpException('Image not found or inaccessible.');
            }
        } catch (\Exception $e) {
            throw new NotFoundHttpException('Failed to load image: ' . $e->getMessage());
        }
    }
}
?>
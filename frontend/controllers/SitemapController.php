<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use common\models\NewsExtranaly as Post;

class SitemapController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = false;

    public function beforeAction($action)
    {
        if (YII_ENV_DEV) {
            Yii::$app->log->targets = [];
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', 'application/xml; charset=utf-8');

        ob_clean(); // 🧹 remove any accidental output buffer
        ob_start();

        $urls = [];

        // Homepage
        $urls[] = [
            'loc' => Url::to('/', true),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // Example static page
        $urls[] = [
            'loc' => Url::to(['/site/about'], true),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.5',
        ];

        $urls[] = [
            'loc' => Url::to(['/privacy-policy.html'], true),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'yearly',
            'priority' => '0.4',
        ];


        $posts = Post::find()->where(['status' => 1])->all();
        foreach ($posts as $post) {
            $lastmod = is_numeric($post->updated_at)
                ? date('Y-m-d', $post->updated_at)
                : substr($post->updated_at, 0, 10);

            $urls[] = [
                'loc' => Url::to(['/' . $post->slug . '-tin-tuc.html'], true),
                'lastmod' => $lastmod,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // Build XML
        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('urlset');
        $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($urls as $u) {
            $xml->startElement('url');
            $xml->writeElement('loc', $u['loc']);
            $xml->writeElement('lastmod', $u['lastmod']);
            $xml->writeElement('changefreq', $u['changefreq']);
            $xml->writeElement('priority', $u['priority']);
            $xml->endElement();
        }

        $xml->endElement(); // urlset
        $xml->endDocument();

        $content = trim($xml->outputMemory());

        // 🚫 ensure no BOM or leading whitespace
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

        ob_end_clean();

        return $content;
    }
}

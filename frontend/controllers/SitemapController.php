<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
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

        ob_clean();
        ob_start();

        $baseUrl = 'https://bdsdaily.com'; // 👈 Ép cố định domain và https

        $urls = [];

        // 🏠 Homepage
        $urls[] = [
            'loc' => $baseUrl . '/',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // ⚙️ Static page
        $urls[] = [
            'loc' => $baseUrl . '/privacy-policy.html',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'yearly',
            'priority' => '0.4',
        ];


        $pages = [
            'phan-mem-nha-pho-ho-chi-minh',
            'phan-mem-nha-pho-binh-duong',
            'phan-mem-nha-pho-vung-tau',
            'phan-mem-nha-pho-da-nang',
            'phan-mem-nha-pho-ha-noi',
            'phan-mem-nha-pho-dong-nai',
            'phan-mem-nha-pho-nha-trang',
            'phan-mem-nha-pho-hai-phong',
            'phan-mem-nha-pho-can-tho',
            'phan-mem-nha-pho-da-lat',
            'phan-mem-nha-pho-hue',
            'phan-mem-nha-pho-thu-dau-mot'
        ];

        foreach ($pages as $slug) {
            $urls[] = [
                'loc' => $baseUrl . '/' . $slug . '.html',
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ];
        }

        // 📰 Dynamic posts
        $posts = \common\models\NewsExtranaly::find()->where(['status' => 1])->all();
        foreach ($posts as $post) {
            $lastmod = is_numeric($post->updated_at)
                ? date('Y-m-d', $post->updated_at)
                : substr($post->updated_at, 0, 10);

            $urls[] = [
                'loc' => $baseUrl . '/' . $post->slug . '-tin-tuc.html',
                'lastmod' => $lastmod,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 🧱 Build XML
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
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

        ob_end_clean();

        return $content;
    }
}

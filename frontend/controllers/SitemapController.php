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

        ob_clean();
        ob_start();

        $urls = [];

        // 🏠 Homepage
        $urls[] = [
            'loc' => Url::to('/', true),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // ⚙️ Static pages
        $urls[] = [
            'loc' => Url::to(['/privacy-policy.html'], true),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'yearly',
            'priority' => '0.4',
        ];

        // 🏗️ 5 Phần mềm Nhà Phố
        $pages = [
            'phan-mem-nha-pho-ho-chi-minh' => 'Phần mềm Nhà Phố Hồ Chí Minh',
            'phan-mem-nha-pho-binh-duong' => 'Phần mềm Nhà Phố Bình Dương',
            'phan-mem-nha-pho-vung-tau' => 'Phần mềm Nhà Phố Vũng Tàu',
            'phan-mem-nha-pho-da-nang' => 'Phần mềm Nhà Phố Đà Nẵng',
            'phan-mem-nha-pho-ha-noi' => 'Phần mềm Nhà Phố Hà Nội',
        ];

        foreach ($pages as $slug => $title) {
            $urls[] = [
                'loc' => Url::to(["/{$slug}.html"], true),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.9',
            ];
        }

        // 📰 Dynamic posts
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

        // 🧱 Build XML Sitemap
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

        // 🚫 Remove BOM or leading whitespace
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

        ob_end_clean();

        return $content;
    }
}

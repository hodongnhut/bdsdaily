<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use common\models\NewsExtranaly as Post;

class SitemapController extends Controller
{
    public $layout = false;

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', 'application/xml; charset=utf-8');

        $urls = [];

        // 🏠 Homepage
        $urls[] = [
            'loc' => Url::to('/', true),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // 📄 Static pages (optional)
        $urls[] = [
            'loc' => Url::to(['/site/about'], true),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.5',
        ];

        // 📰 Dynamic Posts
        $posts = Post::find()
            ->where(['status' => 1])
            ->orderBy(['updated_at' => SORT_DESC])
            ->all();

        foreach ($posts as $post) {
            $lastmod = $post->updated_at;
            if (is_numeric($lastmod)) {
                $lastmod = date('Y-m-d', $lastmod);
            } else {
                $lastmod = substr($lastmod, 0, 10);
            }

            $urls[] = [
                'loc' => Url::to(['/' . $post->slug . '-tin-tuc.html'], true),
                'lastmod' => $lastmod,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }


        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('urlset');
        $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($urls as $url) {
            $xml->startElement('url');
            $xml->writeElement('loc', $url['loc']);
            $xml->writeElement('lastmod', $url['lastmod']);
            $xml->writeElement('changefreq', $url['changefreq']);
            $xml->writeElement('priority', $url['priority']);
            $xml->endElement();
        }

        $xml->endElement(); // urlset
        $xml->endDocument();

        return $xml->outputMemory();
    }
}

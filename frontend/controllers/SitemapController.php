<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use common\models\NewsExtranaly as News; // change to your models

class SitemapController extends Controller
{
    // We don't need layout for XML output
    public $layout = false;

    public function actionIndex()
    {
        // Return raw XML
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', 'application/xml; charset=utf-8');
        Yii::$app->response->headers->set('Cache-Control', 'max-age=86400, public'); // cache 1 day

        $urls = [];

        // 1) Add homepage & static pages
        $urls[] = [
            'loc' => Url::to(['/site/index'], true),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        $urls[] = [
            'loc' => Url::to(['/site/about'], true),
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.5',
        ];


        $posts = News::find()->where(['status' => 1])->all();
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

        foreach ($urls as $u) {
            $xml->startElement('url');
            $xml->writeElement('loc', $u['loc']);
            if (!empty($u['lastmod'])) $xml->writeElement('lastmod', $u['lastmod']);
            if (!empty($u['changefreq'])) $xml->writeElement('changefreq', $u['changefreq']);
            if (!empty($u['priority'])) $xml->writeElement('priority', $u['priority']);
            $xml->endElement(); // url
        }

        $xml->endElement(); // urlset
        return $xml->outputMemory();
    }
}

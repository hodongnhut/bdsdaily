<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'privacy-policy.html' => 'site/privacy-policy',
                '<slug>-tin-tuc.html' => 'new/view',
                'tin-tuc.html' => 'new',
                'sitemap.xml' => 'sitemap/index',
                'phan-mem-nha-pho-ho-chi-minh.html' => 'site/phan-mem-nha-pho-ho-chi-minh',
                'phan-mem-nha-pho-binh-duong.html' => 'site/phan-mem-nha-pho-binh-duong',
                'phan-mem-nha-pho-vung-tau.html' => 'site/phan-mem-nha-pho-vung-tau',
                'phan-mem-nha-pho-da-nang.html' => 'site/phan-mem-nha-pho-da-nang',
                'phan-mem-nha-pho-ha-noi.html' => 'site/phan-mem-nha-pho-ha-noi'
            ],
        ],
    ],
    'params' => $params,
];

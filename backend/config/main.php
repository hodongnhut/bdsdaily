<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'gii'],
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'],
        ],
    ],
    'language' => 'vi',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'secureHeaders' => [
                'X-Forwarded-For',
                'X-Forwarded-Host',
                'X-Forwarded-Proto',
                'X-Forwarded-Port',
            ],
            'secureProtocolHeaders' => [
                'X-Forwarded-Proto' => ['https'],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'authTimeout' => 1800,
            'as sessionChecker' => [
                'class' => 'common\components\SessionChecker',
            ],
        ],
        'session' => [
            'name' => 'advanced-backend',
            'timeout' => 1800,
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
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/post',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/auth',
                    'extraPatterns' => [
                        'POST login'  => 'login',
                        'POST logout' => 'logout',
                        'GET me'      => 'me',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/property',
                    'extraPatterns' => [
                        'GET index'  => 'index',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/new',
                ],
                'POST api/post/add-property-history/<property_id:\d+>' => 'api/post/add-property-history',
                'GET api/post/view-property/<external_id:[\w-]+>' => 'api/post/view-property',
                'POST api/post/create-property' => 'api/post/create-property',
                'PUT api/post/update-property/<external_id:[\w-]+>' => 'api/post/update-property',
                'POST api/properties/<property_id:\d+>/add-contact' => 'api/post/add-owner-contact',
                
                'property-folder' => 'site/property-folder',
                'property-user' => 'site/property-user',
                'login-version' => 'site/login-version',
                'change-password' => 'site/change-password',
                'news' => 'news/index',
                'user/map/<id:\d+>' => 'user/map',
                'login-version' => 'user-location',
                'news' => 'post',
                'property-folder' => 'folder',
                'ban-do-quy-hoach' => 'site/map',
                'ban-do-quy-hoach-ho-chi-minh' => 'site/map-ho-chi-minh',
                'mobile-map' => 'site/mobile-map',
                'map/<path:.+>' => 'map/proxy',
                'property/<action:[\w-]+>' => 'property/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

            ],
        ],
    ],
    'on beforeAction' => function ($event) {
        $sessionChecker = Yii::$app->user->getBehavior('sessionChecker');
        if ($sessionChecker) {
            $sessionChecker->checkAuthKeySession(); 
        }
    },
    'params' => $params,
];

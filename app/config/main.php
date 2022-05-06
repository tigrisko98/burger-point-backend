<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-app',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-app',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class
            ]
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-app', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the app
            'name' => 'advanced-app',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
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
                'POST /user/register' => '/auth/register',
                'POST /user/login' => '/auth/login',
                'DELETE /user/logout' => '/auth/logout',
                '/auth/verify-email' => '/auth/verify-email',
                '/user/test' => '/auth/test',

                ['class' => \yii\rest\UrlRule::class, 'controller' => ['category', 'product']],

                'GET /settings' => '/settings/settings',
                'GET /settings/about-us' => '/settings/about-us',
                'GET /settings/contacts' => '/settings/contacts',

                'POST /reserve' => '/reservation/create',
                'GET /enabled-tables' => '/reservation/enabled-tables'

            ],
        ],
    ],
    'params' => $params,
];

<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'aliases' => [
        '@web' => getenv('YII_WEB_ALIAS') ?: '/frontend/web',
        '@webroot' => getenv('YII_WEBROOT_ALIAS') ?: dirname(__DIR__) . '/web',
    ],
    'name' => 'BeyondTube',
    'defaultRoute' => '/video/index',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'channel/<username:[\w\-\.]+>' => 'channel/view',
                'channel/subscribe/<username:[\w\-\.]+>' => 'channel/subscribe',
                'channel/subscribe' => 'channel/subscribe',
                // ... other rules ...
            ],
        ],
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
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'dsn' => 'smtp://' . $_ENV['SMTP_USER'] . ':' . $_ENV['SMTP_PASS'] . '@' . $_ENV['SMTP_HOST'] . ':' . $_ENV['SMTP_PORT']
            ],
            'messageConfig' => [
                'from' => [$_ENV['SMTP_FROM_EMAIL'] => $_ENV['SMTP_FROM_NAME']],
            ],
        ],
    ],
    'params' => $params,
];

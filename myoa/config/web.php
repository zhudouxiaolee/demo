<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'defaultRoute' => 'back/index',
    //'homeUrl' => 'back/index/index',
    'modules' => [
        'back' => [
            'class' => 'app\modules\back\backend',
        ],
        'front' => [
            'class' => 'app\modules\front\frontend',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '-ihH-IkaqI-q99_zb_itLmfVV2N8ieJ_',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //配置组件user来管理用户的认证状态
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ''
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        //url美化
        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'ruleConfig' => ['class' => 'yii\web\UrlRule'],
            'rules' => [
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<modules:\w+>/<controller:\w+>/<action:\w+>' => '<modules>/<controller>/<action>'
            ],
            'suffix' => '.jsp'
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

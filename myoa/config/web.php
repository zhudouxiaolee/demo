<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    //'timeZone' => 'Asia/shanghai',
    'timeZone' => 'PRC',
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
    //配置组件
    'components' => require(__DIR__ . '/components.php'),
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
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

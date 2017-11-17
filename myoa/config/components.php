<?php
/*
 * 配置组件
 */
return [
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
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.163.com',
            'username' => '',
            'password' => '',
            'port' => '587',
            'encryption' => 'ssl',//    tls | ssl
        ],
        'messageConfig'=>[
            'charset'=>'UTF-8',
        ],
    ],
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning'],
            ],
            [
                'class' => 'yii\log\EmailTarget',
                // In the above `mailer` is ID of the component that sends email and should be already configured.
                'mailer' => 'mailer',
                'levels' => ['error', 'warning'],
                'message' => [
                    'from' => [''],
                    'to' => [''],
                    'subject' => 'OaLog message',
                ],
            ],
        ]
    ],
    'db' => require(__DIR__ . '/db.php'),
    //url美化
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'enableStrictParsing' => false,
        'ruleConfig' => ['class' => 'yii\web\UrlRule'],
        'rules' => [
            //'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            '<modules:\w+>/<controller:\w+>/<action:\w+>' => '<modules>/<controller>/<action>'
        ],
        'suffix' => '.jsp'
    ],
];

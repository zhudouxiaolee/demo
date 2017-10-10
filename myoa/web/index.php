<?php

// comment out the following two lines when deployed to production
// 关闭debug
defined('YII_DEBUG') or define('YII_DEBUG', false);
// 开启生产环境prod(dev:开发环境)
defined('YII_ENV') or define('YII_ENV', 'prod');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../tools/function.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/8/15
 * Time: 14:51
 * Description:提示信息依赖加载
 */

namespace app\assets;

use yii\web\AssetBundle;

class MessageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/common.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
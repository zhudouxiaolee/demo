<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'layer/layer.js',
        'js/common.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    /**
     * addJsFile.
     * @access
     * @param $view object 视图层
     * @param $jsFile string 文件路径
     * @return void
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-12
     * Time: 16:38:29
     * Description:按需依赖加载js文件
     */
    public static function addJsFile($view, $jsFile) {
        $view->registerJsFile($jsFile, ['depends' => AppAsset::className()]);
    }

    /**
     * addCssFile.
     * @access
     * @param $view object 视图层
     * @param $cssFile string 文件路径
     * @return void
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-12
     * Time: 16:44:02
     * Description:按需依赖加载css文件
     */
    public static function addCssFile($view, $cssFile) {
        $view->registerCssFile($cssFile, ['depends' => AppAsset::className()]);
    }
}

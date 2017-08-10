<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/6/16
 * Time: 16:34
 * Description:
 */


namespace app\modules\back\controllers;


use yii\helpers\Markdown;
use yii\web\Controller;

class IndexController extends Controller
{
    /**
     * actionIndex.
     * @access
     * @return string
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-11
     * Time: 11:10:41
     * Description:首页
     */
    public function actionIndex() {
        $cache = \Yii::$app->cache;
        //$cache->set('age', 100, 10);
        //vp($cache->get('age'));
        return $this->render('home');
    }

}
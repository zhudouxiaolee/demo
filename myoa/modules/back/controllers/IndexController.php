<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/6/16
 * Time: 16:34
 * Description:
 */


namespace app\modules\back\controllers;


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
        return $this->render('home');
    }

}
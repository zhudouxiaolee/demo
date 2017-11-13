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
     * init.
     * @access
     * @return void
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-11-13
     * Time: 11:39:53
     * Description:重写父类init，防止对游客判断造成重定向
     */
    public function init(){}

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
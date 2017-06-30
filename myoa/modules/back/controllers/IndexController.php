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
    public function actionIndex() {
        return $this->render('home');
    }

    public function actionLogin() {
        return $this->render('login');
    }
}
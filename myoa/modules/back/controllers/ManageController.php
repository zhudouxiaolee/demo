<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/6/22
 * Time: 9:40
 * Description:用户管理
 */

namespace app\modules\back\controllers;


use app\models\LoginsForm;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ManageController extends Controller
{
    //登录界面
    public function actionLogin() {
        $loginForm = new LoginsForm();
        $loginForm->scenario = 'login';
        //判断是否为登录(是：执行登录判断；否：显示登录界面)
        $requestComponent = Yii::$app->request;
        if($requestComponent->isPost) {
            $app = Yii::$app;
            //获取该模型所提交的表单内容
            $postData = $requestComponent->post($loginForm->formName());//vp($postData);
            $userInfo = User::isLogin($postData['username'], $postData['password']);
            if(!$userInfo) {
                return $this->goBack();
            }
            return $this->redirect(['/back/official/index']);
        }
        return $this->render('login', compact('loginForm'));
    }

    //退出登录
    public function actionLogout() {
        //注销登录
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionAjax() {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $loginForm = new LoginsForm();
            $loginForm->scenario = 'login';
            $data = $request->post();
            if($request->isPost && $loginForm->load($data)) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($loginForm);
            }
        }
    }
}
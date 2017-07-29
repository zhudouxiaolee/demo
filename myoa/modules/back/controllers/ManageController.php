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
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ManageController extends Controller
{
    /**
     * actionLogin.
     * @access
     * @return string|Response
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-12
     * Time: 15:45:14
     * Description:登陆界面
     */
    public function actionLogin() {
        $loginForm = new LoginsForm();
        $loginForm->scenario = 'login';
        //判断是否为登录(是：执行登录判断；否：显示登录界面)
        $requestComponent = Yii::$app->request;
        if($requestComponent->isPost) {
            //获取该模型所提交的表单内容
            $postData = $requestComponent->post($loginForm->formName());
            $userInfo = User::isLogin($postData['username'], $postData['password']);
            if(!$userInfo) {
                return $this->goBack();
            }
            return $this->redirect(['/back/official/index']);
        }
        return $this->render('login', compact('loginForm'));
    }

    /**
     * actionLogout.
     * @access
     * @return Response
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-12
     * Time: 15:45:30
     * Description:退出登录
     */
    public function actionLogout() {
        //注销登录
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * actionAjax.
     * @access
     * @return array|bool
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-12
     * Time: 15:46:00
     * Description:ajax异步验证登录用户
     */
    public function actionAjax() {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $loginForm = new LoginsForm();
            $loginForm->scenario = 'login';
            $data = $request->post();
            if($request->isPost && $loginForm->load($data)) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($loginForm);
            }else {
                return false;
            }
        }else {
            return false;
        }
    }

    /**
     * actionUserInfo.
     * @access
     * @return array|mixed
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-24
     * Time: 17:52:15
     * Description:更新密码
     */
    public function actionUserInfo() {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        if($request->isAjax) {
            $postData = $request->post();
            //判断操作类型(0：检测密码是否正确；1：更新密码)
            if($postData['type']) {
                //更新密码
                if(User::alterPasswd($postData['passwd'])) {
                    $response->data = ['msg' => '修改成功', 'status' => 1, 'url' => Url::to(['manage/logout'])];
                }else {
                    $response->data = ['msg' => '未修改', 'status' => 0];
                }
            }else {
                //判断输入的旧密码是否正确
                if(User::isAlter($postData['passwd'])) {
                    $response->data = ['msg' => '密码正确', 'status' => 1];
                }else {
                    $response->data = ['msg' => '密码错误', 'status' => 0];
                }
            }
        }else {
            $response->data = ['msg' => '非法访问', 'status' => 0];
        }
        return $response->data;
    }

    public function actionTest() {
        $arr = ['22', 's' => 212];
        print_r($arr);
    }

    public function actionE() {
        $url = 'http://myoa.com/index.php?r=back/manage/test';
        $data = $this->curl($url);
        print_r($data);
    }
}
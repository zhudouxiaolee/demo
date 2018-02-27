<?php
/**
 * Created by PhpStorm.
 * User: Sun
 * Date: 2018/2/27
 * Time: 11:24
 * Description:
 */

namespace app\modules\wechat\controller;


use app\models\WxBizDataCrypt;
use Yii;
use yii\web\Controller;

class WechatProcedureController extends Controller
{
    /*
     * 禁止csrf校验
     */
    public $enableCsrfValidation = false;
    const APP_ID = 'wxcf4886e8e5ea7fe4';//输入小程序appid
    const APP_SECRET = 'ab34b420e9db0fd21d48aaf9594a4d0e';//输入小程序app_secret

    /**
     * init.
     * @access
     * @return void
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-11-13
     * Time: 14:44:51
     * Description:重写父类方法，不进行登录用户的认证
     */
    public function init(){}

    public function actionGetSessionKey() {
        $com = Yii::$app->request;
        if($com->getIsGet() && $getData = $com->get()) {
            $url = "https://api.weixin.qq.com/sns/jscode2session";
            $params = ['appid' => self::APP_ID, 'secret' => self::APP_SECRET] + $getData;
            $result = $this->curl($url, $params);
            $this->asJson($result);
        }
    }

    public function actionGetOpenid() {
        $com = Yii::$app->request;
        if($com->getIsGet() && $getData = $com->get()) {
            $appid = self::APP_ID;
            $sessionKey = $getData['session_key'];
            $encryptedData = $getData['encryptedData'];
            $iv = $getData['iv'];
            $pc = new WxBizDataCrypt($appid, $sessionKey);
            $errCode = $pc->decryptData($encryptedData, $iv, $data);
            if ($errCode == 0) {
                $this->asJson($data);
            } else {
                $this->asJson($errCode);
            }
        }
    }
}
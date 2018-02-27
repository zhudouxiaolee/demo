<?php
/**
 * Created by PhpStorm.
 * User: Sun
 * Date: 2018/2/27
 * Time: 11:24
 * Description:
 */

namespace app\modules\wechat\controller;


use Yii;
use yii\web\Controller;

class WechatProcedureController extends Controller
{
    /*
     * 禁止csrf校验
     */
    public $enableCsrfValidation = false;

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

    public function actionGetOpenid() {
        $com = Yii::$app->request;
        if($com->getIsGet() && $getData = $com->get()) {
            $url = "https://api.weixin.qq.com/sns/jscode2session";
            $result = $this->curl($url, $getData);
            $this->asJson($result);
        }
    }
}
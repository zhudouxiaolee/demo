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
            $appid = $getData['appid'];
            $sessionKey = $result['session_key'];

            $encryptedData="CiyLU1Aw2KjvrjMdj8YKliAjtP4gsMZM
                QmRzooG2xrDcvSnxIMXFufNstNGTyaGS
                9uT5geRa0W4oTOb1WT7fJlAC+oNPdbB+
                3hVbJSRgv+4lGOETKUQz6OYStslQ142d
                NCuabNPGBzlooOmB231qMM85d2/fV6Ch
                evvXvQP8Hkue1poOFtnEtpyxVLW1zAo6
                /1Xx1COxFvrc2d7UL/lmHInNlxuacJXw
                u0fjpXfz/YqYzBIBzD6WUfTIF9GRHpOn
                /Hz7saL8xz+W//FRAUid1OksQaQx4CMs
                8LOddcQhULW4ucetDf96JcR3g0gfRK4P
                C7E/r7Z6xNrXd2UIeorGj5Ef7b1pJAYB
                6Y5anaHqZ9J6nKEBvB4DnNLIVWSgARns
                /8wR2SiRS7MNACwTyrGvt9ts8p12PKFd
                lqYTopNHR1Vf7XjfhQlVsAJdNiKdYmYV
                oKlaRv85IfVunYzO0IKXsyl7JCUjCpoG
                20f0a04COwfneQAGGwd5oa+T8yO5hzuy
                Db/XcxxmK01EpqOyuxINew==";

            $iv = 'r7BXXKkLb8qrSNn05n0qiA==';

            $pc = new WxBizDataCrypt($appid, $sessionKey);
            $errCode = $pc->decryptData($encryptedData, $iv, $data);

            if ($errCode == 0) {
                //print($data . "\n");
                $this->asJson($data);
            } else {
                //print($errCode . "\n");
                $this->asJson($errCode);
            }

        }
    }
}
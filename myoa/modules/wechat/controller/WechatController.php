<?php

namespace app\modules\wechat\controller;

use Yii;
use yii\web\Controller;

class WechatController extends Controller
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
     * Time: 15:08:14
     * Description:重写父类方法，不进行登录用户的认证
     */
    public function init(){}

    public function actionIndex() {
        if(!isset($_GET['echostr'])) {
            $this->responseMsg();
        }else {
            $this->valid();
        }
    }

    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = Yii::$app->params['weixintoken'];
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        // php7 去除了$GLOBALS["HTTP_RAW_POST_DATA"]
        // $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        // 临时路径
        $runtime = Yii::getAlias('@runtime') . '/logs/wechat.log';

        $postStr = file_get_contents('php://input');
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            // 日志记录
            //file_put_contents($runtime, var_export($postObj, true), FILE_APPEND);
            $RX_TYPE = trim($postObj->MsgType);

            switch ($RX_TYPE)
            {
                // 菜单点击
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                // 文本
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
                // 图片
                case 'image':
                    $result = $this->transmitImage($postObj);
                    break;
                // 语音
                case 'voice':
                    $result = $this->transmitVoice($postObj);
                    break;
                // 视频
                case 'video':
                    $result = $this->transmitVideo($postObj);
                    break;
                // 位置
                case 'location':
                    $result = '';
                    break;
                // 链接
                case 'link':
                    $result = '';
                    break;
                default:
                    $result = '';
                    break;
            }
            echo $result;
        }else {
            echo "";
            exit;
        }
    }

    private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event)
        {
            case "subscribe":
                $content = "欢迎关注yh工作室";
                break;
            case "unsubscribe":
                $content = "取消关注";
                break;
            case 'click':
                switch ($object->EventKey) {
                    case 'company':
                        $content[] = array("Title" =>"yh工作室简介",
                            "Description" =>"yh工作室提供各种生活相关的服务",
                            "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg",
                            "Url" =>"weixin://addfriend/pondbaystudio");
                }

                break;
        }
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //接收文本消息
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        //$content = date("Y-m-d H:i:s",time())."\n技术支持 方倍工作室";
        switch ($keyword) {
            case '天气':
                $content = '天气好';
                break;
            default:
                $content = $keyword;
                break;
        }

        if(is_array($content)){
            if (isset($content[0]['PicUrl'])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }

        return $result;
    }


    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    private function transmitNews($object, $arr_item)
    {
        if(!is_array($arr_item))
            return;

        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);

        $newsTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item));
        return $result;
    }

    private function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
</Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    /*
     * 格式化图片消息
     */
    private function transmitImage($object){
        $imageTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<Image>
<MediaId><![CDATA[%s]]></MediaId>
</Image>
</xml>";
        $result = sprintf($imageTpl, $object->FromUserName, $object->ToUserName,time(), $object->MediaId);
        return $result;
    }

    /*
     * 格式化语音消息
     */
    private function transmitVoice($object) {
        $voiceTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
<Voice>
<MediaId><![CDATA[%s]]></MediaId>
</Voice>
</xml>";
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($voiceTpl, $object->FromUserName, $object->ToUserName, time(), $object->MediaId);
        //$result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), '您刚刚说的内容是：'.$object->Recognition);
        return $result;
    }

    private function transmitVideo($object) {
        $videoTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
<Video>
<MediaId><![CDATA[%s]]></MediaId>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
</Video> 
</xml>";
        $result = sprintf($videoTpl, $object->FromUserName, $object->ToUserName, time(), $object->MediaId, '', '');
        return $result;
    }
}

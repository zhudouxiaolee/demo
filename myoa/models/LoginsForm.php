<?php
/**
 * Created by PhpStorm.
 * User: SunYuHeng
 * Date: 2017/6/22
 * Time: 9:55
 * Description:表单模型
 */

namespace app\models;


use Yii;
use yii\base\Model;

class LoginsForm extends Model
{
    //属性
    public $username;
    public $password;
    public $code;
    //登录场景
    const SCENARIO_LOGIN = 'login';
    //注册场景
    const SCENARIO_REGISTER = 'register';

    //属性标签
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'code' => '验证码',
        ];
    }
    //规则
    public function rules()
    {
        return [
            [['username', 'password', 'code'], 'required', 'on' => 'login', 'message' => '{attribute}不能为空'],
            ['username', 'string', 'max' => 18, 'tooLong' => '{attribute}最多{max}位字符'],
            ['password', 'string', 'min' => 6, 'tooShort' => '{attribute}最少{min}位字符', 'on' => 'register'],
            ['username', 'validateUsername', 'skipOnError' => false, 'on' => 'login'],
            ['password', 'validatePassword', 'skipOnError' => false, 'on' => 'login'],
            ['code', 'captcha', 'captchaAction' => 'back/manage/code', 'on' => 'login', 'message' => '{attribute}错误']
        ];
    }
    //场景
    public function scenarios()
    {
        return [
            self::SCENARIO_LOGIN => ['username', 'password', 'code'],
            self::SCENARIO_REGISTER => ['username', 'password'],
        ];
    }

    /**
     * validateUsername.
     * @access
     * @param $attribute string 用户名
     * @param $param
     * @return string|boolean
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-06-27
     * Time: 12:05:00
     * Description:验证用户名是否存在
     */
    public function validateUsername($attribute, $param) {
        $rows = User::findOneByUsername($this->$attribute);
        if(!$rows) {
            return $this->addError($attribute, '用户名不存在');
        }
        return true;
    }
    //自定义规则--验证密码
    public function validatePassword($attribute, $params) {
        $rows = User::isLogin($this->username, $this->$attribute);
        if(!$rows) {
            return $this->addError($attribute, '密码错误');
        }
        //注册用户实体
        Yii::$app->user->login($rows);
        $rows->lastlogin = time();
        $rows->lastip = Yii::$app->request->userIP;
        $rows->update();
        return true;
    }
}
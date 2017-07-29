<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $lastlogin
 * @property string $lastip
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 32],
            [['lastlogin'], 'integer'],
            [['lastip'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'username' => '用户名',
            'password' => '密码',
            'lastlogin' => '最后登录时间',
            'lastip' => '最后登录ip地址',
        ];
    }

    /**
     * isLogin.
     * @access
     * @param $username string 用户名
     * @param $password integer 密码
     * @return static 用户信息对象
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-06-23
     * Time: 19:05:10
     * Description:用户登录验证
     */
    public static function isLogin($username, $password) {
        return static::findOne(['username' => $username, 'password' => md5($password)]);
    }

    /**
     * findOneByUsername.
     * @access
     * @param $username string 用户名
     * @return static
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-06-27
     * Time: 12:03:17
     * Description:根据用户名查询
     */
    public static function findOneByUsername($username) {
        return static::findOne(['username' => $username]);
    }

    /**
     * findIdentity.
     * @access
     * @param int|string $id 被查询的ID
     * @return static 通过ID匹配到的身份对象
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-06-23
     * Time: 18:44:08
     * Description:根据给到的ID查询身份
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return static::findOne($id);
    }

    /**
     * findIdentityByAccessToken.
     * @access
     * @param mixed $token 被查询的token
     * @param null $type
     * @return static 通过token查询到的身份对象
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-06-23
     * Time: 18:47:24
     * Description:根据token查询身份
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
        return static::findOne(['access_token' => $token]);
    }

    /**
     * getId.
     * @access
     * @return int 当前用户ID
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-06-23
     * Time: 18:49:39
     * Description:返回当前用户ID
     */
    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    /**
     * getAuthKey.
     * @access
     * @return mixed
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-06-23
     * Time: 18:51:34
     * Description:当前用户（cookie）认证密钥
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
        return $this->auth_key;
    }

    /**
     * validateAuthKey.
     * @access
     * @param string $authKey
     * @return bool
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-06-23
     * Time: 19:02:30
     * Description:验证认证密钥
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
        return $this->getAuthKey() === $authKey;
    }

    /**
     * getOfficialList.
     * @access
     * @return \yii\db\ActiveQuery
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-20
     * Time: 17:41:21
     * Description:获取该用户下的所有日程
     */
    public function getOfficialList() {
        /**
         * 第一个参数为要关联的子表模型类名称，
         * 第二个参数指定通过子表的 uid 去关联主表的 id 字段
         */
        return $this::hasMany(Official::className(), ['uid' => 'id']);
    }

    /**
     * getNotesList.
     * @access
     * @return \yii\db\ActiveQuery
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-26
     * Time: 16:09:31
     * Description:获取该用户下的所有笔记
     */
    public function getNotesList() {
        return $this->hasMany(Notes::className(), ['uid' => 'id']);
    }

    /**
     * getCategory.
     * @access
     * @return \yii\db\ActiveQuery
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-28
     * Time: 09:54:45
     * Description:查找该用户下的所有笔记分类
     */
    public function getCategory() {
        return $this->hasMany(Category::className(), ['uid' => 'id']);
    }

    /**
     * isAlter.
     * @access
     * @return boolean
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-24
     * Time: 17:33:35
     * Description:判断是否可以修改密码
     */
    public static function isAlter($passwd) {
        $id = Yii::$app->user->id;
        $user = static::findOne($id);
        if($user['password'] == md5($passwd)){
            return true;
        }else {
            return false;
        }
    }

    /**
     * alterPasswd.
     * @access
     * @param $passwd
     * @return int
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-24
     * Time: 17:53:38
     * Description:更新密码
     */
    public static function alterPasswd($passwd) {
        $id = Yii::$app->user->id;
        return static::updateAll(['password' => md5($passwd)], ['id' => $id]);
    }
}

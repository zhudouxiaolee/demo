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
}

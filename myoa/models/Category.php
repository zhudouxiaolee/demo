<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $addtime
 * @property integer $updatetime
 * @property integer $uid
 * @property integer $pid
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id', 'addtime', 'updatetime', 'uid', 'pid'], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名称',
            'addtime' => '增加时间',
            'updatetime' => '更新时间',
            'uid' => '用户ID',
            'pid' => '父级ID,默认一级分类pid=0；二级分类pid=2；',
        ];
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * cateAdd.
     * @access
     * @param $name string 分类名称
     * @return bool
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-29
     * Time: 14:05:02
     * Description:添加分类
     */
    public function cateAdd($name) {
        $this->name = $name;
        $this->addtime = time();
        $this->updatetime = 0;
        $this->uid = Yii::$app->user->id;
        $this->pid = 0;
        $rows = $this->save();
        if($rows) {
            return true;
        }else {
            return false;
        }
    }
}

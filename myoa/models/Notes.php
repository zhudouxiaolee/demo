<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%notes}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $addtime
 * @property integer $updatetime
 * @property integer $cateid
 * @property integer $uid
 */
class Notes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['addtime', 'updatetime', 'cateid', 'uid'], 'integer'],
            [['title'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'title' => '标题摘要',
            'content' => '笔记内容',
            'addtime' => '添加时间',
            'updatetime' => '更新时间',
            'cateid' => '分类ID，默认0未分配分类',
            'uid' => '用户ID',
        ];
    }

    /**
     * @inheritdoc
     * @return NotesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotesQuery(get_called_class());
    }

    /**
     * notesAdd.
     * @access
     * @param $param array 需要添加的内容
     * @return bool
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-26
     * Time: 15:06:31
     * Description:添加笔记
     */
    public function notesAdd($param) {
        $this->title = $param['title'];
        $this->content = $param['content'];
        $this->addtime = time();
        $this->updatetime = 0;
        $this->cateid = 0;
        $this->uid = Yii::$app->user->id;
        $rows = $this->insert();
        if($rows) {
            return true;
        }else {
            return false;
        }
    }
}

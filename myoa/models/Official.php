<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%official}}".
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property integer $time
 * @property integer $uid
 */
class Official extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%official}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['time', 'uid'], 'integer'],
            [['title'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'title' => '标题',
            'content' => '日程内容',
            'time' => '时间',
            'uid'  => '用户ID',
        ];
    }

    /**
     * saveOfficialRecord.
     * @access
     * @param $title
     * @param $content
     * @return bool
     * Created by User: SunYuHeng
     * Last Modify User: SunYuHeng
     * Date: 2017-07-05
     * Time: 14:12:59
     * Description:存储今日办公日程

     */
    public function saveOfficialRecord($title, $content) {
        $this->title = $title;
        $this->content = $content;
        $this->time = time();
        $this->uid  =   Yii::$app->user->id;
        $rows = $this->save();
        if($rows) {
            return true;
        }else {
            return false;
        }
    }

    /**
     * @inheritdoc
     * @return OfficialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OfficialQuery(get_called_class());
    }
}

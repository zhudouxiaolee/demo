<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Notes]].
 *
 * @see Notes
 */
class NotesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Notes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Notes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

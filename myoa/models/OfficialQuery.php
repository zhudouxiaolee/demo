<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Official]].
 *
 * @see Official
 */
class OfficialQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Official[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Official|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

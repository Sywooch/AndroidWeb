<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AppPart]].
 *
 * @see AppPart
 */
class AppPartQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AppPart[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AppPart|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

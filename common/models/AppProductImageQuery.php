<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AppProductImage]].
 *
 * @see AppProductImage
 */
class AppProductImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AppProductImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AppProductImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

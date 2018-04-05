<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AppProductOrders]].
 *
 * @see AppProductOrders
 */
class AppProductOrdersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AppProductOrders[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AppProductOrders|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AppCategory]].
 *
 * @see AppCategory
 */
class AppCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AppCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AppCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

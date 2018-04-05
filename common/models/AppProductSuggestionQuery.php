<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AppProductSuggestion]].
 *
 * @see AppProductSuggestion
 */
class AppProductSuggestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AppProductSuggestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AppProductSuggestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

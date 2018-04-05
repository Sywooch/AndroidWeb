<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AppLogs]].
 *
 * @see AppLogs
 */
class AppLogsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AppLogs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AppLogs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

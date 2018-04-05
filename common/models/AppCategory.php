<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "app_category".
 *
 * @property int $id
 * @property string $name
 * @property int $is_defined
 */
class AppCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'is_defined'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['is_defined'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'is_defined' => 'Is Defined',
        ];
    }

    /**
     * @inheritdoc
     * @return AppCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppCategoryQuery(get_called_class());
    }
}

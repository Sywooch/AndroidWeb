<?php

namespace common\models;

use Yii;
use common\models\AppCategory;
/**
 * This is the model class for table "app_sub_category".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property int $is_defined
 */
class AppSubCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_sub_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'is_defined'], 'required'],
            [['category_id'], 'integer'],
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
            'category_id' => 'Category ID',
            'name' => 'Name',
            'is_defined' => 'Is Defined',
        ];
    }

    /**
     * @inheritdoc
     * @return AppSubCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppSubCategoryQuery(get_called_class());
    }

    public function getCatName()
    {
        return $this->hasOne(AppCategory::className(), ['id' => 'category_id']);
    }
}

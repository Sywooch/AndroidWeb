<?php

namespace common\models;

use Yii;
use common\models\AppCategory;
use common\models\AppSubCategory;
/**
 * This is the model class for table "app_part".
 *
 * @property int $id
 * @property int $sub_category_id
 * @property string $name
 * @property int $category_id
 * @property int $is_defined
 */
class AppPart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_part';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sub_category_id', 'name', 'category_id'], 'required'],
            [['sub_category_id', 'category_id', 'is_defined'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sub_category_id' => 'Sub Category ID',
            'name' => 'Name',
            'category_id' => 'Category ID',
            'is_defined' => 'Is Defined',
        ];
    }

    /**
     * @inheritdoc
     * @return AppPartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppPartQuery(get_called_class());
    }

     public function getSubCatName()
    {   
        return $this->hasOne(AppSubCategory::className(), ['id' => 'sub_category_id']);
    }

     public function getCatName()
    {   
        return $this->hasOne(AppCategory::className(), ['id' => 'category_id']);
    }

    public function AddParts($name,$cat_id,$sub_cat_id){
        $data = new AppPart();

        $data->sub_category_id = $sub_cat_id;
        $data->name = $name;
        $data->category_id = $cat_id;
        $data->is_defined = 0;

        return $data->save(false)?$data:null;
    }
}

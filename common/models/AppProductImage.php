<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "app_product_image".
 *
 * @property int $id
 * @property int $enquiry_product_id
 * @property string $image
 * @property string $alt_text
 */
class AppProductImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_product_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enquiry_product_id', 'image', 'alt_text'], 'required'],
            [['enquiry_product_id'], 'integer'],
            [['alt_text'], 'string'],
            [['image'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'enquiry_product_id' => 'Enquiry Product ID',
            'image' => 'Image',
            'alt_text' => 'Alt Text',
        ];
    }

    /**
     * @inheritdoc
     * @return AppProductImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppProductImageQuery(get_called_class());
    }

    public function SaveImage($enquiry_product_id,$path){
        $app_product_image = new AppProductImage();

        $app_product_image->enquiry_product_id = $enquiry_product_id;
        $app_product_image->image = $path;

        return $app_product_image->save(false)?$app_product_image:null;
    }
}

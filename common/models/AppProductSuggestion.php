<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "app_product_suggestion".
 *
 * @property int $id
 * @property int $enquiry_product_id
 * @property string $brand
 * @property string $quality
 * @property string $availability
 * @property int $shipping_time
 * @property double $shipping_charges
 * @property double $tax
 * @property double $warranty
 * @property double $vendor_price
 * @property string $part_url
 */
class AppProductSuggestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_product_suggestion';
    }

      public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['part_name','brand', 'quality', 'availability', 'shipping_time', 'shipping_charges', 'tax', 'warranty', 'vendor_price'], 'required'],
            [['enquiry_product_id', 'shipping_time'], 'integer'],
            [['shipping_charges', 'tax', 'warranty', 'vendor_price'], 'number'],
            [['brand'], 'string', 'max' => 50],
            [['quality', 'availability'], 'string', 'max' => 30],
            [['part_url'], 'string', 'max' => 300],
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
            'part_name' => 'Part Name',
            'brand' => 'Brand',
            'quality' => 'Quality',
            'availability' => 'Availability',
            'shipping_time' => 'Shipping Time',
            'shipping_charges' => 'Shipping Charges',
            'tax' => 'Tax',
            'warranty' => 'Warranty',
            'vendor_price' => 'Vendor Price',
            'part_url' => 'Part Url',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     * @return AppProductSuggestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppProductSuggestionQuery(get_called_class());
    }

    public function getSuggestion($enquiry_product_id){
        $data = self::find()
                    ->where(['enquiry_product_id'=>$enquiry_product_id])
                    ->all();
        $array = [];
        foreach ($data as $key) {
            $array[] = $key;
        }
        return $array;

    }

    public function searchBySuggestion($id){
        $data = self::find()
                    ->where(['id'=>$id])
                    ->one();
        return $data;
    }
}

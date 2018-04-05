<?php

namespace common\models;

use Yii;
use common\models\AppPart;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "app_enquiry_products".
 *
 * @property int $id
 * @property int $enquiry_id
 * @property int $part_id
 * @property string $requirement_detail
 * @property string $agent_remark
 */
class AppEnquiryProducts extends \yii\db\ActiveRecord
{   
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_enquiry_products';
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
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enquiry_id', 'part_id','agent_remark'], 'required'],
            [['enquiry_id', 'part_id'], 'integer'],
            [['requirement_detail', 'agent_remark'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'enquiry_id' => 'Enquiry ID',
            'part_id' => 'Part ID',
            'requirement_detail' => 'Requirement Detail',
            'agent_remark' => 'Agent Remark',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By'
        ];
    }

    /**
     * @inheritdoc
     * @return AppEnquiryProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppEnquiryProductsQuery(get_called_class());
    }

    public function saveEnqueryProducts($rec_enq_id,$part_id,$requirement_detail,$agent_remark){
        $enqPrdt = new AppEnquiryProducts();
        $enqPrdt->enquiry_id = $rec_enq_id;
        $enqPrdt->part_id = $part_id;
        $enqPrdt->requirement_detail = $requirement_detail;
        $enqPrdt->agent_remark = $agent_remark;

        return $enqPrdt->save(false)?$enqPrdt:null;
    }

    public function PrdtSugg($enquiry_id){
        $data = self::find()
                    ->joinWith(['partName'])
                    ->where(['enquiry_id'=>$enquiry_id])
                    ->all();
        return $data;
    }

     public function getPartName()
    {   
        return $this->hasOne(AppPart::className(), ['id' => 'part_id']);
    }
}

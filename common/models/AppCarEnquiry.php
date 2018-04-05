<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use modules\users\models\User;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "app_car_enquiry".
 *
 * @property int $id
 * @property int $user_id
 * @property string $car_chassis_number
 * @property string $brand
 * @property string $model
 * @property string $variant
 * @property string $engine
 * @property string $year
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 */
class AppCarEnquiry extends \yii\db\ActiveRecord
{   
    public $rep_email;
    public $enq_source;
    public $user_name;
     public $created;
     public $mobile;
     public $detail;
     public $order_id;
     public $add_reason;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_car_enquiry';
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
            [['user_id', 'brand', 'model', 'variant', 'engine', 'year', 'created_at', 'updated_at', 'status','detail'], 'required'],

            ['order_id', 'required', 'whenClient' => "function (attribute, value) {
                return ($('select[id=with_order_id]').val() == 1);
            }"],

            ['add_reason', 'required', 'whenClient' => "function (attribute, value) {
                return ($('select[id=with_order_id]').val() == 2);
            }"],

            ['reason', 'required', 'whenClient' => "function (attribute, value) {
                return ($('select[id=add_reason_id]').val() == 4);
            }"],

            [[ 'updated_at', 'status','created_by'], 'integer'],
            [['car_chassis_number'], 'string', 'max' => 50],
            [['brand', 'model', 'variant', 'engine'], 'string', 'max' => 100],
            [['year'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'car_chassis_number' => 'Car Chassis Number',
            'brand' => 'Brand',
            'model' => 'Model',
            'variant' => 'Variant',
            'engine' => 'Engine',
            'year' => 'Year',
            'reason' => 'Reason',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    /**
     * @inheritdoc
     * @return AppCarEnquiryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppCarEnquiryQuery(get_called_class());
    }

    public function saveEnquiry($user_id,$car_chassis_number,$model,$variant,$engine,$year,$brand,$partdetails){
        $carEnquiry = new AppCarEnquiry();
        $carEnquiry->user_id = $user_id;
        $carEnquiry->car_chassis_number = $car_chassis_number;
        $carEnquiry->model = $model;
        $carEnquiry->variant = $variant;
        $carEnquiry->engine = $engine;
        $carEnquiry->year = $year;
        $carEnquiry->brand = $brand;

        return $carEnquiry->save(false)?$carEnquiry:null;
    }

    public function fetchEnqId($user_id){
        $data = self::find()
                     ->select(['id','created_at'])
                     ->where(['user_id'=>$user_id])
                     ->all();
        return $data;

    }

    public function fetchEnqData($id,$user_id){
        $data = self::find()
                    ->select(['id','car_chassis_number','brand','model','variant','engine','year'])
                    ->where(['id'=>$id,'user_id'=>$user_id])
                    ->one();
        return $data;
    }

    
    public function getUserName()
    {   
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


}

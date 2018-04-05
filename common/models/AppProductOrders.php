<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "app_product_orders".
 *
 * @property int $order_id
 * @property int $user_id
 * @property string $txn_id
 * @property double $amount
 * @property string $shipping_time
 * @property string $product_info
 * @property string $status
 * @property int $created_at
 */
class AppProductOrders extends \yii\db\ActiveRecord
{   
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_product_orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'txn_id', 'shipping_time', 'product_info', 'status', 'created_at'], 'required'],
            [['user_id', 'created_at','updated_at'], 'integer'],
            [['amount'], 'number'],
            [['txn_id', 'shipping_time'], 'string', 'max' => 50],
            [['product_info'], 'string', 'max' => 10],
            [['status'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
            'txn_id' => 'Txn ID',
            'amount' => 'Amount',
            'shipping_time' => 'Shipping Time',
            'product_info' => 'Product Info',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return AppProductOrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppProductOrdersQuery(get_called_class());
    }

    public function DisplayOrder($uid){
        $x = self::find()
                ->select(['order_id','amount','created_at','status'])
                ->where(['user_id'=>$uid])
                ->all();
        return $x;
    }

    public function saveProductOrder($user_id,$txn_id,$amount,$shipping_time,$product_info,$status){
        $x = new AppProductOrders();
        $x->user_id = $user_id;
        $x->txn_id = $txn_id;
        $x->amount = $amount;
        $x->shipping_time = $shipping_time;
        $x->product_info = $product_info;
        $x->status = $status;

        return $x->save(false)?$x:null;
    }

    public function FetchProductOrder($user_id,$order_id){
        $data = self::find()
                    ->where(['user_id'=>$user_id,'order_id'=>$order_id])
                    ->one();
        return $data;
    }
}

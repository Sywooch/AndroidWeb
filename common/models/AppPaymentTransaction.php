<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "app_payment_transaction".
 *
 * @property int $transaction_id
 * @property int $user_id
 * @property string $payment_id
 * @property string $status
 * @property string $date
 * @property string $transaction_message
 * @property string $bank_ref_number
 * @property string $bank_code
 * @property string $card_number
 * @property string $name_on_card
 */
class AppPaymentTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_payment_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'payment_id', 'status', 'date', 'transaction_message', 'bank_ref_number', 'bank_code', 'card_number', 'name_on_card'], 'required'],
            [['user_id'], 'integer'],
            [['payment_id', 'status', 'date', 'transaction_message', 'bank_ref_number', 'bank_code', 'card_number', 'name_on_card'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transaction_id' => 'Transaction ID',
            'user_id' => 'User ID',
            'payment_id' => 'Payment ID',
            'status' => 'Status',
            'date' => 'Date',
            'transaction_message' => 'Transaction Message',
            'bank_ref_number' => 'Bank Ref Number',
            'bank_code' => 'Bank Code',
            'card_number' => 'Card Number',
            'name_on_card' => 'Name On Card',
        ];
    }

    /**
     * @inheritdoc
     * @return AppPaymentTransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppPaymentTransactionQuery(get_called_class());
    }

    public function FetchDetails($uid){
        $data = self::find()
                    ->select(['transaction_id'])
                    ->where(['user_id'=>$uid])
                    ->all();
        return $data;
    }

    public function FetchDetailsTransaction($uid,$transaction_id){
        $data = self::find()
                    ->where(['user_id'=>$uid,'transaction_id'=>$transaction_id])
                    ->one();
        return $data;
    }
}

<?php
namespace api\modules\v1\controllers;

use yii;
use yii\rest\Controller;
use modules\users\models\User;
use common\models\AppPaymentTransaction;

class PaymentController extends Controller
{	
	public function actionTransactionId($user_id){
    $appPaymentTransaction = new AppPaymentTransaction();

    $data  = $appPaymentTransaction->FetchDetails($user_id);
    $array = [];
    foreach($data as $x){
      $array[] = ['transaction_id'=>$x['transaction_id']];
    }

    $response = [];

    if(empty($array)){
       $response = [
          'status'=>400,
          'success' => false,
          'message'=>'No record found!'
        ];
    }else{
       $response = [
          'status'=>200,
          'success' => true,
          'result'=>$array
        ];
    }

    return $response;
  }

    public function actionTransactionDetail($user_id,$transaction_id){
    $appPaymentTransaction = new AppPaymentTransaction();

    $data  = $appPaymentTransaction->FetchDetailsTransaction($user_id,$transaction_id);

    $response = [];

    if(empty($data)){
       $response = [
          'status'=>400,
          'success' => false,
          'message'=>'No record found!'
        ];
    }else{
       $response = [
          'status'=>200,
          'success' => true,
          'result'=>$data
        ];
    }

    return $response;
  }

   public function actionPayuHash(){
         $name = !empty($_POST['firstname'])?$_POST['firstname']:'';
        $email = !empty($_POST['email'])?$_POST['email']:'';
        $amount = !empty($_POST['amount'])?$_POST['amount']:'';
        $m_key = !empty($_POST['key'])?$_POST['key']:'';
        $salt = !empty($_POST['salt'])?$_POST['salt']:'';
        $prdt_info = !empty($_POST['productinfo'])?$_POST['productinfo']:'';
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        
      
                $hashSequence = "$m_key|".$txnid."|$amount|$prdt_info|$name|$email|||||||||||$salt";
                $hash = hash('sha512', $hashSequence);
                $response = [
                    'success'=>true,
                    'result_txnid'=>$txnid,
                    'result_hash'=>$hash,
                  ];
          
        
     // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return $response;
    }

  public function actionPaytmHash(){
        $MID = !empty($_POST['MID'])?$_POST['MID']:'';
        $M_KEY = !empty($_POST['M_KEY'])?$_POST['M_KEY']:'';
        $CUST_ID = !empty($_POST['CUST_ID'])?$_POST['CUST_ID']:'';
        $INDUSTRY_TYPE_ID = !empty($_POST['INDUSTRY_TYPE_ID'])?$_POST['INDUSTRY_TYPE_ID']:'';
        $CHANNEL_ID = !empty($_POST['CHANNEL_ID'])?$_POST['CHANNEL_ID']:'';
        $TXN_AMOUNT = !empty($_POST['TXN_AMOUNT'])?$_POST['TXN_AMOUNT']:'';
        $WEBSITE = !empty($_POST['WEBSITE'])?$_POST['WEBSITE']:'';
        
        $ORDER_ID = "AUTO_".substr(rand(), 0, 7);
       
        
        if(!empty($MID) && !empty($M_KEY) && !empty($ORDER_ID) && !empty($CUST_ID) && !empty($INDUSTRY_TYPE_ID) && !empty($CHANNEL_ID) && !empty($TXN_AMOUNT) && !empty($WEBSITE)){
             $checkSum = "";
        $findme   = 'REFUND';
        $findmepipe = '|';
        
        $paramList = array();
        $paramList["MID"] = $MID;
        $paramList["ORDER_ID"] = $ORDER_ID;
        $paramList["CUST_ID"] = $CUST_ID;
        $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
        $paramList["CHANNEL_ID"] = $CHANNEL_ID;
        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
        $paramList["WEBSITE"] = $WEBSITE;
        
        $checkSum = $this->getChecksumFromArray($paramList,$M_KEY);
                $response = [
                    'status'=>200,
                    'result'=>[
                        'result_order_id'=>$ORDER_ID,
                        'result_hash'=>$checkSum
                    ],
                  ];
        }else{
            $response = [
                'status'=>400,
                'message'=>'error',
              ];
        }
      return $response;
    }

    public function getChecksumFromArray($arrayList, $key, $sort=1) {
    if ($sort != 0) {
      ksort($arrayList);
    }
    $str = $this->getArray2Str($arrayList);
    $salt = $this->generateSalt_e(4);
    $finalString = $str . "|" . $salt;
    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;
    $checksum = $this->encrypt_e($hashString, $key);
    return $checksum;
  }

  public function getArray2Str($arrayList) {
    $findme   = 'REFUND';
    $findmepipe = '|';
    $paramStr = "";
    $flag = 1;  
    foreach ($arrayList as $key => $value) {
      $pos = strpos($value, $findme);
      $pospipe = strpos($value, $findmepipe);
      if ($pos !== false || $pospipe !== false) 
      {
        continue;
      }
      
      if ($flag) {
        $paramStr .= $this->checkString_e($value);
        $flag = 0;
      } else {
        $paramStr .= "|" . $this->checkString_e($value);
      }
    }
    return $paramStr;
  }

  public function generateSalt_e($length) {
    $random = "";
    srand((double) microtime() * 1000000);
    $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
    $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
    $data .= "0FGH45OP89";
    for ($i = 0; $i < $length; $i++) {
      $random .= substr($data, (rand() % (strlen($data))), 1);
    }
    return $random;
  }

    public function encrypt_e($input, $ky) {
    $key = $ky;
    $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
    $input = $this->pkcs5_pad_e($input, $size);
    $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
    $iv = "@@@@&&&&####$$$$";
    mcrypt_generic_init($td, $key, $iv);
    $data = mcrypt_generic($td, $input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $data = base64_encode($data);
    return $data;
  }
    public function checkString_e($value) {
    if ($value == 'null')
      $value = '';
    return $value;
  }

  public function pkcs5_pad_e($text, $blocksize) {
    $pad = $blocksize - (strlen($text) % $blocksize);
    return $text . str_repeat(chr($pad), $pad);
  }

}
?>
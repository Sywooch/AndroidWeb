<?php
namespace api\modules\v1\controllers;

use yii;
use yii\rest\Controller;
use modules\users\models\User;
use common\models\AppCarEnquiry;
use common\models\AppEnquiryProducts;
use common\models\AppProductImage;
use yii\helpers\Url;
use common\models\AppProductOrders;
use common\models\AppProductSuggestion;
use common\models\AppPart;

class EnquiryController extends Controller
{	
	public function actionEnquiry(){
   
    $post_data  = json_decode(Yii::$app->getRequest()->getBodyParams(),true);
    $user_id = !empty($post_data['user_id'])?$post_data['user_id']:'';
   
    $car_chassis_number = !empty($post_data['car_chassis_number'])?$post_data['car_chassis_number']:'';
    $model = !empty($post_data['model'])?$post_data['model']:'';
    $variant = !empty($post_data['variant'])?$post_data['variant']:'';
    $engine = !empty($post_data['engine'])?$post_data['engine']:'';
    $year = !empty($post_data['year'])?$post_data['year']:'';
    $brand = !empty($post_data['brand'])?$post_data['brand']:'';
    $partdetails[] = !empty($post_data['partdetails'])?$post_data['partdetails']:'';
    if(empty($post_data['partdetails'])){
      array_pop($partdetails);
    }
   // print_r($partdetails);
    $response = [];
    if(!empty($partdetails)){
    $carEnquiry = new AppCarEnquiry();
    
      $x = $carEnquiry->saveEnquiry($user_id,$car_chassis_number,$model,$variant,$engine,$year,$brand,$partdetails);
      $rec_enq_id = $x['id'];
    //  print_r($x['id']);exit();
         foreach ($partdetails as $parts) {
         foreach ($parts as $part) {
           $requirement_detail = $part['requirement_detail'];
          $agent_remark = $part['agent_remark'];
          $part_id = $part['part_id'];
         // print_r($part_id);
          $is_defined = $part['is_defined'];
          if($is_defined == 1){
          
            $appEnquiryProducts = new AppEnquiryProducts();
          
          $y = $appEnquiryProducts->saveEnqueryProducts($rec_enq_id,$part_id,$requirement_detail,$agent_remark);
      
          $this->ReturnUrl($y['id'],$part['partimage']);
          }else{
           
             $part_name = $part['part_name'];
            $appPart = new AppPart();
            $data = $appPart->AddParts($part_name,14,126);
            $rec_part_id = $data['id'];
             $appEnquiryProducts = new AppEnquiryProducts();
            $y = $appEnquiryProducts->saveEnqueryProducts($rec_enq_id,$rec_part_id,$requirement_detail,$agent_remark);
            $this->ReturnUrl($y['id'],$part['partimage']);
          }
         }
        }
      $response = [
        'status'=>200,
        'success' => true,
        'message' => 'Thank you! your data has been posted.',
      ];
    }
    else{
      $response = [
        'status'=>500,
        'success' => false,
        'message' => 'Please enter requirements',
      ];
    }
    return $response;
  }

  public function ReturnUrl($x,$img){
      foreach ($img as $key) {
        $path = Url::to('@upload') . DIRECTORY_SEPARATOR.'uploads/enq/';
        $img1 = str_replace('data:image/png;base64,', '', $key);
        $img2 = str_replace(' ', '+', $key);
        $data = base64_decode($key);
        $z = uniqid() . '.png';
        $file = $path . $z;
        $success = file_put_contents($file, $data);
        // return $success ? $file : 'Unable to save the file.';
        $AppProductImage = new AppProductImage();
        $srv = $_SERVER['SERVER_NAME'];
        $path = $srv.'/frontend/web\uploads/enq/'.$z;
        $AppProductImage->SaveImage($x,$path);
      }
  }

  public function actionOrderId($user_id){
    $AppProductOrders = new AppProductOrders();
    
     $response = [];
    $res = $AppProductOrders->DisplayOrder($user_id);
    $array = [];
    foreach ($res as $key) {
      $order_id = $key['order_id'];
      $amount = $key['amount'];
      $created_at = $key['created_at'];
      $status = $key['status'];
      $array[] = ['order_id'=>$order_id,'amount'=>$amount,'created_at'=>$created_at,'status'=>$status];
    }

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

  public function actionEnquiryForm($user_id){
     $AppCarEnquiry = new AppCarEnquiry();

    $data  = $AppCarEnquiry->fetchEnqId($user_id);
    $array = [];
    foreach ($data as $key) {
      $array[] = ['id'=>$key['id'],'created_at'=>$key['created_at']];
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

  public function actionProductOrder(){
    $post_data = Yii::$app->request->post();
    $user_id = !empty($post_data['user_id'])?$post_data['user_id']:'';
    $txn_id = !empty($post_data['txn_id'])?$post_data['txn_id']:'';
    $amount = !empty($post_data['amount'])?$post_data['amount']:'';
    $shipping_time = !empty($post_data['shipping_time'])?$post_data['shipping_time']:'';
    $product_info = !empty($post_data['product_info'])?$post_data['product_info']:'';
    $status = !empty($post_data['status'])?$post_data['status']:'';
    $user_id = !empty($post_data['user_id'])?$post_data['user_id']:'';

    $response = [];
    if(!empty($post_data) && !empty($user_id)  && !empty($amount) && !empty($shipping_time) && !empty($product_info)&& !empty($status)){
      $appProductOrders = new AppProductOrders();
    
      $x = $appProductOrders->saveProductOrder($user_id,$txn_id,$amount,$shipping_time,$product_info,$status);
      $response = [
        'status'=>200,
        'success' => true,
        'message' => 'Thank you! your data has been posted.',
      ];
    }else{
      $response = [
        'status'=>400,
        'success' => false,
        'message' => 'Data insufficient!',
      ];
    }
    return $response;
  }

  public function actionOrderDetail($user_id,$order_id){
    $appProductOrders = new AppProductOrders();
    $data = $appProductOrders->FetchProductOrder($user_id,$order_id);
    $array = ['order_id'=>$data['order_id'],'user_id'=>$data['user_id'],'txn_id'=>$data['txn_id'],'amount'=>$data['amount'],'shipping_time'=>$data['shipping_time'],'status'=>$data['status'],'created_at'=>$data['created_at'],'updated_at'=>$data['updated_at'],'product_info'=>$this->findProductSuggestion($data['product_info'])];
    if(!empty($data)){
      $response = [
        'status'=>200,
        'success' => true,
        'result' => $array,
      ];
    }else{
      $response = [
        'status'=>400,
        'success' => false,
        'message' => 'Record Not found!'
      ];
    }

    return $response;
  }

  public function findProductSuggestion($suggestion){
    $exploded_data = explode(',', $suggestion);
    $appProductSuggestion = new AppProductSuggestion();
    $x = [];
    foreach ($exploded_data as $key) {
      if(!is_null($y = $appProductSuggestion->searchBySuggestion($key))){
        $x[] = $y;
      }else{
        $x = [];
      }
    }

    return $x;
  }

  public function actionTest(){
    $post_data = Yii::$app->request->post();
    $response = [];
     $response = [
        'status'=>200,
        'success' => true,
        'result' => $post_data,
      ];
      return $response;
  }
}
?>
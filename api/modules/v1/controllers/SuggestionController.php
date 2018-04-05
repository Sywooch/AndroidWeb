<?php
namespace api\modules\v1\controllers;

use yii;
use yii\rest\Controller;
use modules\users\models\User;
use common\models\AppEnquiryProducts;
use common\models\AppProductSuggestion;
use common\models\AppCarEnquiry;

class SuggestionController extends Controller
{	
	public function actionProductSuggestion($user_id,$id){
    $appEnquiryProducts = new AppEnquiryProducts();
    $appProductSuggestion = new AppProductSuggestion();

    $data = $appEnquiryProducts->PrdtSugg($id);
    $part_details = [];
    foreach ($data as $key) {
      $part_details[] = ['id'=>$key['id'],'enquiry_id'=>$key['enquiry_id'],'part_id'=>$key['part_id'],'part_name'=>$key['partName']['name'],'requirement_detail'=>$key['requirement_detail'],'agent_remark'=>$key['agent_remark'],'suggestions'=>$appProductSuggestion->getSuggestion($key['id'])];
    }

    $appCarEnquiry = new AppCarEnquiry();
    $carInq = $appCarEnquiry->fetchEnqData($id,$user_id);
     $array = ['id'=>$carInq['id'],'car_chassis_number'=>$carInq['car_chassis_number'],'brand'=>$carInq['brand'],'model'=>$carInq['model'],'variant'=>$carInq['variant'],'engine'=>$carInq['engine'],'year'=>$carInq['year'],'part_details'=>$part_details];


    $response = [
    'status'=>200,
    'success' => true,
    'result'=>$array
    ];
    return $response;
  }

}
?>
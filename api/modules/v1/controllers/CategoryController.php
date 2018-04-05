<?php
namespace api\modules\v1\controllers;

use yii;
use yii\rest\Controller;
use modules\users\models\User;
use yii\helpers\Url;
use common\models\AppCategory;
use common\models\AppSubCategory;
use common\models\AppPart;

class CategoryController extends Controller
{	
	public function actionIndex(){
    $model = AppPart::find()
                       ->joinWith(['subCatName','catName'])
                      ->all();
    //print_r($model[0]['subCatName']);
    $response = [];
    $array = [];
    foreach ($model as $key) {
    	$array[] = ['category_id'=>$key['catName']['id'],'category_name'=>$key['catName']['name'],'subcategory_id'=>$key['subCatName']['id'],'subcategory_name'=>$key['subCatName']['name'],'part_id'=>$key['id'],'part_name'=>$key['name']];
    }
     $response = [
          'status'=>200,
          'success' => true,
          'result'=>$array
        ];
    return $response;
  }

}
?>
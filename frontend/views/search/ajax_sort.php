<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\Product;
use yii\widgets\Pjax;
$this->title = 'Product Listing';
$this->params['breadcrumbs'][] = $this->title;

$path = Yii::$app->request->baseUrl;
//print_r($products);
// $image='';
?>	

							<!--product -->
							
							<?php echo rawurldecode(\yii\widgets\ListView::Widget([
										'dataProvider'=>$products,
										 'itemOptions' => ['class' => 'item'],
										'layout' => '{items}{pager}',
										'itemView'=>'_products',
										// 'viewParams' => ['image' => $image],
										'pager' => ['class' => \kop\y2sp\ScrollPager::className(),
											            'enabledExtensions'  => [
											                \kop\y2sp\ScrollPager::EXTENSION_SPINNER,
											                \kop\y2sp\ScrollPager::EXTENSION_NONE_LEFT,
											                \kop\y2sp\ScrollPager::EXTENSION_PAGING,
											                //\kop\y2sp\ScrollPager::EXTENSION_HISTORY,
											            ],
											            'spinnerTemplate'=>'<div class="ias-spinner" style="text-align: center;"><img src="https://carsonspecial.com/wp-content/themes/cardealer/images/preloader_img/loader.gif"/></div>',
													],
					
										]));?>

									
						
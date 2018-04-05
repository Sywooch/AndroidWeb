<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\Product;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\Brand;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\CarInfo;
use kartik\widgets\DepDrop;
use app\models\CarInfoDropdown;

$this->title = 'Product Listing';
$this->params['breadcrumbs'][] = $this->title;

$path = Yii::$app->request->baseUrl;

?>	
		<main class="site-main" >

				<div class="columns container">
					<!-- Block  Breadcrumb-->
					<div class="row">
						
						<!-- Main Content -->
						<div class="col-md-9 col-md-push-3  col-main">
							
							<!-- images categori -->
							<div class="category-view">
								<div class="owl-carousel " 
                                data-nav="true" 
                                data-dots="false" 
                                data-margin="0" 
                                data-items='1' 
                                data-autoplayTimeout="700" 
                                data-autoplay="true" 
                                data-loop="true">
									<div class="item " >
										<a href=""><img src="<?= $path?>/images/cat-top1.jpg" alt="category-images"></a>
									</div>
									<div class="item " >
										<a href=""><img src="<?= $path?>/images/cat-top2.jpg" alt="category-images"></a>
									</div>
								</div>
							</div><!-- images categori -->
							
							<!-- Toolbar -->
							<div class=" toolbar-products toolbar-top">
								
								<div class="btn-filter-products">
									<span>Filter</span>
								</div>
								
								<h2 class="cate-title"></h2>
								
								<div class="modes">
									<strong  class="label">View as:</strong>
									<strong  class="modes-mode active mode-grid" title="Grid">
										<span>grid</span>
									</strong>
									<a  href="catlist.php" title="List" class="modes-mode mode-list">
										<span>list</span>
									</a>
								</div><!-- View as -->
								
								<div class="toolbar-option">
									
									<div class="toolbar-sorter ">
										<label    class="label">Sort by:</label>
						
											<select class="sorter-options form-control" id="sort_type">
											<option  value="0" selected="selected">--Default--</option>
											<option value="1" >Popularity</option>
											<option value="2">Newest</option>
											<option value="3">Oldest</option>
										</select>
										
										<a href="" class="sorter-action"></a>
									</div><!-- Short by -->
									
									<div class="toolbar-limiter">
										<label   class="label">
											<span>Show:</span>
										</label>
										
										<select class="limiter-options form-control" id="page_size">
											<option selected="selected" value="4">30</option>
											<option value="5">60</option>
											<option value="6">100</option>
										</select>
										
									</div><!-- Show per page -->
									
								</div>

							</div><!-- Toolbar -->
							
							<!-- List Products -->
							<div class="products  products-grid" id="ajaxchange">
							<!--product -->
	
									<?php echo rawurldecode(\yii\widgets\ListView::Widget([
										'dataProvider'=>$products,
										 'itemOptions' => ['class' => 'item'],
										'layout' => '{items}{pager}',
										'itemView'=>'_products',
										'pager' => ['class' => \kop\y2sp\ScrollPager::className(),
											            'enabledExtensions'  => [
											                \kop\y2sp\ScrollPager::EXTENSION_SPINNER,
											                //ScrollPager::EXTENSION_NONE_LEFT,
											                \kop\y2sp\ScrollPager::EXTENSION_PAGING,
											            ],
											            'spinnerTemplate'=>'<div class="ias-spinner" style="text-align: center;"><img src="https://carsonspecial.com/wp-content/themes/cardealer/images/preloader_img/loader.gif"/></div>',
													],
					
										]));?>

						    <!-- end list product -->
							</div>

							
						</div><!-- Main Content -->
						
						<!-- Sidebar -->
						<div class="col-md-3 col-md-pull-9  col-sidebar">
							
							<!-- Block  bestseller products-->
							<div class="block-sidebar block-sidebar-categorie">
								<div class="block-title">
									<strong>All Categories</strong>
								</div>
								<div class="block-content">
									<ul class="items">
										 <?php foreach($this->params['categories'] as $category):?>
										<li class="parent">
											<a href="<?= Url::toRoute(['shop/'.$category['slug']])?>"><?= $category['name']?></a>
											<span class="toggle-submenu"></span>
											<ul class="subcategory">
												<?php foreach($this->params['sub_category'][$category['cat_id']] as $x):?>
												<li ><a href="<?= Url::toRoute(['shop/'.$category['slug'].'/'.$x['slug']])?>"><?= $x['name']?></a></li>
												<?php endforeach;?>
											</ul>
										</li>
									<?php endforeach;?>
									</ul>
								</div>
							</div><!-- Block  bestseller products-->
							
							<!-- block filter products -->
							<div id="layered-filter-block" class="block-sidebar block-filter no-hide">
								<div class="close-filter-products"><i class="fa fa-times" aria-hidden="true"></i></div>
								<div class="block-title">
									<strong>FILTER SELECTION</strong>
								</div>
								<div class="block-content">
									
																		<!-- Filter Item Make Model-->
									<div class="filter-options-item filter-options-categori">
										<div class="filter-options-title">Make / Model Filter</div>
										<div class="filter-options-content">
											<?php $form = ActiveForm::begin(['id' => 'dropdown-form']); ?>
											<?= $form->field($model1, 'name')->label('Brand')->dropDownList(ArrayHelper::map(CarInfo::find()->select(['ci_id','name'])->where(['type'=>1])->all(), 'ci_id', 'name'), ['id'=>'cat-id','prompt'=>'Select Brand',
												'onchange'=>"
												var brand_id = $(this).val();
												//alert(brand_id);
												var search_key = $('#xx2').val();
												var url = $('#xx').val();
												var end_slug = $('#xx1').val();
												var brnd_select = $('#brnd_select').val();
												var page_size = $('#page_size option:selected').text();
												var sort_type = $('#sort_type option:selected').val();
												var sort_type_name = $('#sort_type option:selected').text();
												$('#ajaxchange').load(url,{page_size:page_size,sort_type:sort_type,end_slug,brnd_select:brnd_select,car_info_brand:brand_id,search_key:search_key});
												"
											]);
											?>

											<?php
											echo $form->field($model1, 'name')->label('Model')->widget(DepDrop::classname(), [
													'type'=>DepDrop::TYPE_SELECT2,
													'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
												    'options'=>['id'=>'subcat-id','prompt'=>'Select Model'],
												    'pluginOptions'=>[
												        'depends'=>['cat-id'],
												        'placeholder'=>'Select...',
												        'url'=>Url::to(['/search/subcat'])
												    ],
												     'pluginEvents' => [
													    "select2:select" => "function() {
													    	var search_key = $('#xx2').val();
													    	var model_id = $(this).val();
													    	//alert(model_id);
													    	var brand_id = $('#cat-id').val();
													    	var url = $('#xx').val();
															var end_slug = $('#xx1').val();
													    	var brnd_select = $('#brnd_select').val();
															var page_size = $('#page_size option:selected').text();
															var sort_type = $('#sort_type option:selected').val();
															var sort_type_name = $('#sort_type option:selected').text();
															$('#ajaxchange').load(url,{page_size:page_size,sort_type:sort_type,end_slug,brnd_select:brnd_select,brand_id:brand_id,model_id:model_id,search_key:search_key});
													    }",
													],
												]);
											?>

											<?php
											echo $form->field($model1, 'name')->label('Variant')->widget(DepDrop::classname(), [
												'type'=>DepDrop::TYPE_SELECT2,
													'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
												    'options'=>['id'=>'subcat-id1','prompt'=>'Select Variant'],
												    'pluginOptions'=>[
												        'depends'=>['subcat-id'],
												        'placeholder'=>'Select...',
												        'url'=>Url::to(['/search/subcat1'])
												    ],
												        'pluginEvents' => [
													    "select2:select" => "function() {
													    	var search_key = $('#xx2').val();
													    	var variant_id = $(this).val();
													    	var model_id = $('#subcat-id').val();
													    	// alert(model_id);
													    	var brand_id = $('#cat-id').val();
													    	var url = $('#xx').val();
															var end_slug = $('#xx1').val();
													    	var brnd_select = $('#brnd_select').val();
															var page_size = $('#page_size option:selected').text();
															var sort_type = $('#sort_type option:selected').val();
															var sort_type_name = $('#sort_type option:selected').text();
															$('#ajaxchange').load(url,{page_size:page_size,sort_type:sort_type,end_slug,brnd_select:brnd_select,brand_id:brand_id,model_id:model_id,variant_id:variant_id,search_key:search_key});
													    }",
													],
												]);
											?>

											<?php
											echo $form->field($model1, 'name')->label('Fuel Type')->widget(DepDrop::classname(), [
												'type'=>DepDrop::TYPE_SELECT2,
													'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
												    'options'=>['id'=>'subcat-id2','prompt'=>'Select Fuel Type'],
												    'pluginOptions'=>[
												        'depends'=>['subcat-id1'],
												        'placeholder'=>'Select...',
												        'url'=>Url::to(['/search/subcat2'])
												    ],
												          'pluginEvents' => [
													    "select2:select" => "function() {
													    	var search_key = $('#xx2').val();
													    	var fuel_id = $(this).val();
													    	var variant_id = $('#subcat-id1').val();
													    	var model_id = $('#subcat-id').val();
													    	// alert(model_id);
													    	var brand_id = $('#cat-id').val();
													    	var url = $('#xx').val();
															var end_slug = $('#xx1').val();
													    	var brnd_select = $('#brnd_select').val();
															var page_size = $('#page_size option:selected').text();
															var sort_type = $('#sort_type option:selected').val();
															var sort_type_name = $('#sort_type option:selected').text();
															$('#ajaxchange').load(url,{page_size:page_size,sort_type:sort_type,end_slug,brnd_select:brnd_select,brand_id:brand_id,model_id:model_id,variant_id:variant_id,fuel_id:fuel_id,search_key:search_key});
													    }",
													],
												]);
											?>

											<?php
											echo $form->field($model1, 'name')->label('Year')->widget(DepDrop::classname(), [
													'type'=>DepDrop::TYPE_SELECT2,
													'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
												    'options'=>['id'=>'subcat-id4','prompt'=>'Select Year'],
												    'pluginOptions'=>[
												        'depends'=>['subcat-id2'],
												        'placeholder'=>'Select...',
												        'url'=>Url::to(['/search/subcat3'])
												    ],
												       'pluginEvents' => [
													    "select2:select" => "function() {

													    	var year_id = $(this).val();
													    	var fuel_id = $('#subcat-id2').val();
													    	var variant_id = $('#subcat-id1').val();
													    	var model_id = $('#subcat-id').val();
													    	// alert(model_id);
													    	var brand_id = $('#cat-id').val();
													    	var url = $('#xx').val();
													    	var search_key = $('#xx2').val();
															var end_slug = $('#xx1').val();
													    	var brnd_select = $('#brnd_select').val();
															var page_size = $('#page_size option:selected').text();
															var sort_type = $('#sort_type option:selected').val();
															var sort_type_name = $('#sort_type option:selected').text();
															$('#ajaxchange').load(url,{page_size:page_size,sort_type:sort_type,end_slug,brnd_select:brnd_select,brand_id:brand_id,model_id:model_id,variant_id:variant_id,fuel_id:fuel_id,year_id:year_id,search_key:search_key});
													    }",
													],
												]);
											?>
										</div>
									</div><!-- Filter Item  categori-->
								
									 <?php ActiveForm::end();?>
									<!-- filter brad-->
									<div class="filter-options-item filter-options-brand">
										<div class="filter-options-title">BRAND</div>
										<div class="filter-options-content">
									<?php
										echo Select2::widget([
												'id'=>'brnd_select',
											    'name' => 'state_2',
											    'value' => '',
											    'data' => ArrayHelper::map(Brand::find()->select(['brnd_id','name','slug'])->all(), 'brnd_id', 'name'),
											    'options' => ['multiple' => true, 'placeholder' => 'Select Brands ...']
											]);
									?>
										</div>
									</div><!-- Filter Item -->
									
								</div>
							</div><!-- Filter -->
							
							<!-- block slide top -->
							<div class="block-sidebar block-banner-sidebar">
								<div class="owl-carousel" 
                                data-nav="false" 
                                data-dots="true" 
                                data-margin="0" 
                                data-items='1' 
                                data-autoplayTimeout="700" 
                                data-autoplay="true" 
                                data-loop="true">
									<div class="item item1" >
										<img src="<?= $path?>/images/colad1.jpg" alt="images">
									</div>
									<div class="item item2" >
										<img src="<?= $path?>/images/colad2.jpg" alt="images">
									</div>
									<div class="item item3" >
										<img src="<?= $path?>/images/colad3.jpg" alt="images">
									</div>
								</div>
							</div><!-- block slide top -->
							
			
							<!-- block slide top -->
							<div class="block-sidebar block-sidebar-testimonials">
								<div class="block-title">
									<strong>Testimonials</strong>
								</div>
								<div class="block-content">
									<div class="owl-carousel" 
                                    data-nav="false" 
                                    data-dots="true" 
                                    data-margin="0" 
                                    data-items='1' 
                                    data-autoplayTimeout="700" 
                                    data-autoplay="true" 
                                    data-loop="true">
										<div class="item " >
											<strong class="name">Roverto & Maria</strong>
											<div class="avata">
												<img src="<?= $path?>/images/pr01.jpg" alt="avata">
											</div>
											<div class="des">
												"Your product needs to improve more. To suit the needs and update your image up"
											</div>
										</div>
										<div class="item " >
											<strong class="name">Roverto & Maria</strong>
											<div class="avata">
												<img src="<?= $path?>/images/pr02.jpg" alt="avata">
											</div>
											<div class="des">
												"Your product needs to improve more. To suit the needs and update your image up"
											</div>
										</div>
										<div class="item " >
											<strong class="name">Roverto & Maria</strong>
											<div class="avata">
												<img src="<?= $path?>/images/pr03.jpg" alt="avata">
											</div>
											<div class="des">
												"Your product needs to improve more. To suit the needs and update your image up"
											</div>
										</div>
									</div>
								</div>
							</div><!-- block slide top -->
							
							
						</div><!-- Sidebar -->
						
						
						
					</div>
				</div>
				
				
			</main><!-- end MAIN -->

	<input type="hidden" id="xx" value="<?php echo Url::toRoute(['search/sort-by-search'])?>">
	<input type="hidden" id="xx1" value="<?php echo 'all-categories';?>">

	<input type="hidden" id="xx2" value="<?php echo $search_key;?>">


<?php
$js = <<<JS

$(document).ready(function(){
	var url = $("#xx").val();
	var end_slug = $("#xx1").val();
	var search_key = $("#xx2").val();

	
	$('#sort_type').on('change',function (e){
		if($("#sort_type").val() == 0){
			location.reload();
		}else{
			car_info_filtration();
		}
	});
	$('#page_size').on('change',function (e){
		car_info_filtration();
	});

	$('#brnd_select').on('change',function (e){
		car_info_filtration();
	});

	function filter(){
		var brnd_select = $("#brnd_select").val();
		var page_size = $("#page_size option:selected").text();
		var sort_type = $("#sort_type option:selected").val();
		var sort_type_name = $("#sort_type option:selected").text();

			var n = Noty("id");
            $.noty.setText(n.options.id,"<i class=\"fa fa-check\" aria-hidden=\"true\"></i>&nbsp;&nbsp;"+"Successfully Sorted by "+ sort_type_name);
            $.noty.setType(n.options.id, "success");
			$("#ajaxchange").load(url,{page_size:page_size,sort_type:sort_type,end_slug,brnd_select:brnd_select,search_key:search_key});
	}

	function car_info_filtration(){
		var year_id = $('#subcat-id4').val();
    	var fuel_id = $('#subcat-id2').val();
    	var variant_id = $('#subcat-id1').val();
    	var model_id = $('#subcat-id').val();
    	var brand_id = $('#cat-id').val();
		if(brand_id && model_id && variant_id && fuel_id && year_id){
		var brnd_select = $("#brnd_select").val();
		var page_size = $("#page_size option:selected").text();
		var sort_type = $("#sort_type option:selected").val();
		var sort_type_name = $("#sort_type option:selected").text();

		$('#ajaxchange').load(url,{page_size:page_size,sort_type:sort_type,end_slug,brnd_select:brnd_select,brand_id:brand_id,model_id:model_id,variant_id:variant_id,fuel_id:fuel_id,year_id:year_id,search_key:search_key});

		}else if(brand_id && model_id && variant_id && fuel_id){
		var brnd_select = $("#brnd_select").val();
		var page_size = $("#page_size option:selected").text();
		var sort_type = $("#sort_type option:selected").val();
		var sort_type_name = $("#sort_type option:selected").text();

		$('#ajaxchange').load(url,{page_size:page_size,sort_type:sort_type,end_slug,brnd_select:brnd_select,brand_id:brand_id,model_id:model_id,variant_id:variant_id,fuel_id:fuel_id,search_key:search_key});

		}else if(brand_id && model_id && variant_id){
		var brnd_select = $("#brnd_select").val();
		var page_size = $("#page_size option:selected").text();
		var sort_type = $("#sort_type option:selected").val();
		var sort_type_name = $("#sort_type option:selected").text();

		$('#ajaxchange').load(url,{page_size:page_size,sort_type:sort_type,end_slug,brnd_select:brnd_select,brand_id:brand_id,model_id:model_id,variant_id:variant_id,search_key:search_key});

		}else if(brand_id && model_id){
		var brnd_select = $("#brnd_select").val();
		var page_size = $("#page_size option:selected").text();
		var sort_type = $("#sort_type option:selected").val();
		var sort_type_name = $("#sort_type option:selected").text();

		$('#ajaxchange').load(url,{page_size:page_size,sort_type:sort_type,end_slug,brnd_select:brnd_select,brand_id:brand_id,model_id:model_id,search_key:search_key});

		}else if(brand_id){
		var brnd_select = $("#brnd_select").val();
		var page_size = $("#page_size option:selected").text();
		var sort_type = $("#sort_type option:selected").val();
		var sort_type_name = $("#sort_type option:selected").text();

		$('#ajaxchange').load(url,{page_size:page_size,sort_type:sort_type,end_slug,brnd_select:brnd_select,car_info_brand:brand_id,search_key:search_key});

		}else{
			filter();
		}
	}
});
				
JS;
echo $this->registerJs($js);
?>
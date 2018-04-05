<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Product;
use kartik\tabs\TabsX;
use kartik\rating\StarRating;
use yii\widgets\ActiveForm;
use common\models\Review;


$this->title = 'Product';
//print_r($this->params['categories']);
$this->params['breadcrumbs'][] = $this->title;
$path = Yii::$app->request->baseUrl;
$review_model = new Review();

if($seo != null){
$seo->title();
$seo->description();
$seo->keywords();
$seo->meta_title();
}
//print_r($primary_image);
 // print_r($img_array[0]);exit();
?>
<style>
	#img_zoom{
border: 1px solid #e3e3e3;
padding: 10px;
border-top-left-radius: 20px;
border-top-right-radius: 0;
border-bottom-right-radius: 30px;
border-bottom-left-radius: 0;
	}
	#img_zoom1{
border: 1px solid #e3e3e3;
padding: 10px;
	}

</style>
			<main class="site-main">
				<div class="columns container">

					<div class="row">				
						<!-- Main Content -->
							<div class="row">
								
								<div class="col-sm-8 col-md-8 col-lg-6">
									
									<div class="product-media media-horizontal">
										
										<div class="image_preview_container images-large">
										<?php if(empty($img_array[0])):?>
											<img id="img_zoom" data-zoom-image="<?= $path?>/images/full_p01.jpg" src="<?= $path?>/images/full_p01_th.jpg" alt="">
										<?php endif;?>
										<?php if(!empty($img_array[0])):?>
											<?= Html::img($path.'/'.$primary_image[1]['img_path'], ['alt' => $primary_image[1]['alt'],'id'=>'img_zoom','data-zoom-image'=>$path.'/'.$primary_image[1]['img_path']]) ?>
										<?php endif;?>
											</div>
											<br>
											<div class="product_preview images-small">
												
												<div class="owl-carousel thumbnails_carousel" id="thumbnails"  data-nav="true" data-dots="true" data-margin="10" data-responsive='{"0":{"items":3},"480":{"items":4},"600":{"items":5},"768":{"items":3}}' >
												<?php if(empty($img_array[0])):?>
													<a href="#" data-image="<?= $path?>/images/full_p01_th.jpg" data-zoom-image="<?= $path?>/images/full_p01.jpg" >
														
														<img src="<?= $path?>/images/full_p01_th.jpg" data-large-image="<?= $path?>/images/full_p01.jpg" alt="" >
														
													</a>
													
													<a href="#" data-image="<?= $path?>/images/full_p11_th.jpg" data-zoom-image="<?= $path?>/images/full_p11.jpg">
														
														<img src="<?= $path?>/images/full_p11_th.jpg" data-large-image="<?= $path?>/images/full_p11.jpg" alt="">
														
													</a>
													<a href="#" data-image="<?= $path?>/images/full_p10_th.jpg" data-zoom-image="<?= $path?>/images/full_p10.jpg">
														
														<img src="<?= $path?>/images/full_p10_th.jpg" data-large-image="<?= $path?>/images/full_p10.jpg" alt="">
														
													</a>
													<a href="#" data-image="<?= $path?>/images/full_p09_th.jpg" data-zoom-image="<?= $path?>/images/full_p09.jpg">
														
														<img src="<?= $path?>/images/full_p09_th.jpg" data-large-image="<?= $path?>/images/full_p09.jpg" alt="">
													</a>
												<?php endif;?>

										<?php if(!empty($img_array[0])):?>
											<?php foreach ($img_array as $img):?>
												<a href="#" data-image="<?= $path?>/<?= $img['img_path']?>" data-zoom-image="<?= $path?>/<?= $img['img_path']?>">
														
								
														<?= Html::img($path.'/'.$img['img_path'], ['alt' => $img['alt'],'data-large-image'=>$path.'/'.$img['img_path'],'id'=>'img_zoom1']) ?>
													</a>
											<?php endforeach;?>
										<?php endif;?>
										
										<?php if(!empty($img_array_info['manufacture']) && !empty($img_array_info['ci_brand']) && !empty($img_array_info['ci_model'])):?>
												<a href="#" data-image="<?= $path?>/<?= $img_array_info['manufacture'][0]->name?>" data-zoom-image="<?= $path?>/<?= $img_array_info['manufacture'][0]->name?>">
														
								
														<?= Html::img($path.'/'.$img_array_info['manufacture'][0]->name, ['alt' => $img_array_info['manufacture'][0]->alt,'data-large-image'=>$path.'/'.$img_array_info['manufacture'][0]->name,'id'=>'img_zoom1']) ?>
												</a>
												<a href="#" data-image="<?= $path?>/<?= $img_array_info['ci_brand'][0]->name?>" data-zoom-image="<?= $path?>/<?= $img_array_info['ci_brand'][0]->name?>">
														
								
														<?= Html::img($path.'/'.$img_array_info['ci_brand'][0]->name, ['alt' => $img_array_info['ci_brand'][0]->alt,'data-large-image'=>$path.'/'.$img_array_info['ci_brand'][0]->name,'id'=>'img_zoom1']) ?>
												</a>
												<a href="#" data-image="<?= $path?>/<?= $img_array_info['ci_model'][0]->name?>" data-zoom-image="<?= $path?>/<?= $img_array_info['ci_model'][0]->name?>">
														
								
														<?= Html::img($path.'/'.$img_array_info['ci_model'][0]->name, ['alt' => $img_array_info['ci_model'][0]->alt,'data-large-image'=>$path.'/'.$img_array_info['ci_model'][0]->name,'id'=>'img_zoom1']) ?>
												</a>
											<?php endif;?>		

												</div><!--/ .owl-carousel-->
												
											</div><!--/ .product_preview-->
											
										</div><!-- image product -->
									</div>
									
									<div class="col-sm-6 col-md-6 col-lg-6"> 
										
										<div class="product-info-main">
											
											<h1 class="page-title">
												<?= $product['name']?>
											</h1>
											<div class="product-reviews-summary">
												<div class="rating-summary">
													<div class="rating-result" title="70%">
														<span style="width:<?= ($avg_rating*100)?>%">
															<span><span><?= ($avg_rating*100)?></span>% of <span>100</span></span>
														</span>
													</div>
												</div>
												
											</div>
											
											<div class="product-info-price">
												<div class="price-box">
													<span class="price"><h2>Rs.<?= $product['price']-(($product['discount']*$product['price'])/100);?></h2></span>
													<span class="old-price" style="text-decoration: line-through;">Rs.<?= $product['price']?></span>
													<span class="label-sale"><?= $product['discount']?>% OFF</span>
												</div>
											</div>  
											<div class="product-code">
												Item Code: <b>#<?= $product['part_no']?></b>  
											</div>
											<div class="product-code">
												Car Brand : <strong><a href="<?= Url::toRoute(['car/'.$info[0]['ci_brand']])?>"><?= $info[0]['ci_brand_name']?></a></strong>  
											</div>
											<div class="product-code">
												Car Model : <strong><a href="<?= Url::toRoute(['car/'.$info[0]['ci_mdl']])?>"><?= $info[0]['ci_mdl_name']?></a></strong>  
											</div>
											<div class="product-code">
												Car Varient: <strong><a href="<?= Url::toRoute(['car/'.$info[0]['ci_vrnt']])?>"><?= $info[0]['ci_vrnt_name']?></a></strong>  
											</div>
											<div class="product-code">
												Engine: <strong><a href="<?= Url::toRoute(['car/'.$info[0]['ci_engn']])?>"><?= $info[0]['ci_engn_name']?></a></strong>  
											</div>
											<div class="product-code">
												Year: <strong><a href="<?= Url::toRoute(['car/'.$info[0]['ci_year']])?>"><?= $info[0]['ci_year_name']?></a></strong>  
											</div>
											<div class="product-code">
												Availability: <strong>In stock</strong>  
											</div>
											
											<div class="product-condition">
												Manufacturer: <strong><a href="<?= Url::toRoute(['car/'.$info[0]['manufacture_brand']['slug']]);?>"><?= $info[0]['manufacture_brand']['name'];?></a></strong>
											</div>
											<div class="product-overview">
												<div class="overview-content">
													<?= htmlspecialchars_decode($product['dscn_small'])?> 
												</div>
											</div>
											
											<div class="product-add-form">
												
												<form>
													
											<br>
													
													
													
													<div class="product-options-bottom clearfix">
														
														<div class="actions">
															
														<!-- 	<button type="submit" title="Add to Cart" class="action btn-cart" id="add-to-cart-btn">
																<span>Add to Cart</span>
															</button> -->
<input type="hidden" id="hid1" value="<?php echo Url::toRoute(['site/auto-refresh-cart'])?>" name="">
                                        <?= Html::Button('<span>Add to Cart</span>', ['class' => 'action btn-cart','id'=>'add-to-cart-btn','value'=>$product['prdt_id'],'onclick'=>'
                                                                $.post("'.Url::toRoute(['site/add-to-cart']).'",{
                                                                    id : $(this).val(),
                                                                }).done(function(data,status){
                                                                    var data = JSON.parse(data);
                                                                   // alert($("#hid1").val());
                                                                    //alert(data.count);
                                                                    $("#cart_number").html(data.count);
                                                                    $("#cart_number2").html(data.count);
                                                                    $("#cart_number3").html(data.count);
                                                                    $("#total_cost").html(data.cost);
                                                                    $("#total_cost1").html(data.cost);
                                                                    $("#cart_item").load($("#hid1").val());
                                                                    $("#cart_item1").load($("#hid1").val());
                                                                    var n = Noty("id");
                                                            $.noty.setText(n.options.id,"<i class=\"fa fa-check\" aria-hidden=\"true\"></i>&nbsp;&nbsp;"+"product successfully added");
                                                            $.noty.setType(n.options.id, "success");
                                                                });
                                                            ']) ?>
           <!--Li structure changes are in core file style added  -->
                <?= \ymaker\social\share\widgets\SocialShare::widget([
				    'configurator'  => 'socialShare',
				    'url'           => Url::base(true).'/'.Yii::$app->request->getPathInfo(),
				    'title'         => $product['name'],
				    'description'   => Html::decode($product['dscn_large']),
				    'imageUrl'      => 'https://www.autokartz.com/product_image/main5403.jpg',
				]); ?>


															<div class="product-addto-links">
																
																<a href="#" class="action btn-wishlist" title="Wish List">
																	<span>Wishlist</span>
																</a>
																<a href="#" class="action btn-compare" title="Compare">
																	<span>Compare</span>
																</a>
															</div>
														</div>
														
													</div>
													
												</form>
											</div>
											<div class="product-addto-links-second">
												<a href="" class="action action-print">Print</a>
												<a href="" class="action action-friend">Send to a friend</a>
											</div>
										</div><!-- detail- product -->
										
									</div><!-- Main detail -->
									
								</div>
								<BR>
								<!-- product tab info -->
								
								
<?php
if($review_count>0)
{
	$frt1='<div class="container">
    	 	<div class="row">
		   		<div class="col-md-6">
    		<div class="alert alert-info">
			  <strong>Hey!</strong> You have already reviewed and rated this item.Thank you.
			</div>
           ';
 }
 else
 {
$frt1='<div class="container">
    	 	<div class="row">
		   		<div class="col-md-6">
    	
            <div class="text-left">
                <button class="btn btn-success btn-green" id="open-review-box">Leave a Review</button>
            </div>';

 }


$items = [
    [
        'label'=>'<i class="glyphicon glyphicon-home"></i> PRODUCT DETAILS',
        'content'=>htmlspecialchars_decode($product['dscn_large']),
        'active'=>true
    ],
     [
        'label'=>'<i class="glyphicon glyphicon-home"></i> INFORMATION',
        'content'=>'hi1',
       
    ],
     [
        'label'=>'<i class="fa fa-pencil-square" aria-hidden="true"></i> RATING & REVIEWS',
        'content'=> $frt1.'
        
        	<br>
            <div class="row" id="post-review-box" style="display:none;">
                <div class="col-md-12 well well-sm">
                   '.
                   $this->render('rating_form',['model'=>$review_model,'prdt_id'=>$product['prdt_id']])
                   .'
                </div>
            </div>
     		
				                <div class="row">
				                    <div class="col-xs-12 col-md-6 text-center well well-sm">
				                        <h1 class="rating-num">
				                            '.$avg_rating.'</h1>
				                       
				                          
				                            '.
				                            StarRating::widget([
											    'name' => 'rating_12',
											    'value' => $avg_rating,
											    'pluginOptions' => [
											    	'size'=>'sm',
											    	'displayOnly' => true,
											    ]
											])
				                            .'
				                        
				                        <div>
				                            <span class="glyphicon glyphicon-user"></span>'.$total_review_count.' total
				                        </div>
				                    </div>
				                    <div class="col-xs-12 col-md-6">
				                        <div class="row rating-desc">
				                            <div class="col-xs-3 col-md-3 text-right">
				                                <span class="glyphicon glyphicon-star"></span>5
				                            </div>
				                            <div class="col-xs-8 col-md-9">
				                                <div class="progress progress-striped">
				                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20"
				                                        aria-valuemin="0" aria-valuemax="100" style="width: '.round(($five_star*100)/$total_count_star,2).'%">
				                                        <span class="sr-only">'.round(($five_star*100)/$total_count_star,2).'%</span>
				                                    </div>
				                                </div>
				                            </div>
				                            <!-- end 5 -->
				                            <div class="col-xs-3 col-md-3 text-right">
				                                <span class="glyphicon glyphicon-star"></span>4
				                            </div>
				                            <div class="col-xs-8 col-md-9">
				                                <div class="progress">
				                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20"
				                                        aria-valuemin="0" aria-valuemax="100" style="width: '.round(($four_star*100)/$total_count_star,2).'%">
				                                        <span class="sr-only">'.round(($four_star*100)/$total_count_star,2).'%</span>
				                                    </div>
				                                </div>
				                            </div>
				                            <!-- end 4 -->
				                            <div class="col-xs-3 col-md-3 text-right">
				                                <span class="glyphicon glyphicon-star"></span>3
				                            </div>
				                            <div class="col-xs-8 col-md-9">
				                                <div class="progress">
				                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
				                                        aria-valuemin="0" aria-valuemax="100" style="width: '.round(($three_star*100)/$total_count_star,2).'%">
				                                        <span class="sr-only">'.round(($three_star*100)/$total_count_star,2).'%</span>
				                                    </div>
				                                </div>
				                            </div>
				                            <!-- end 3 -->
				                            <div class="col-xs-3 col-md-3 text-right">
				                                <span class="glyphicon glyphicon-star"></span>2
				                            </div>
				                            <div class="col-xs-8 col-md-9">
				                                <div class="progress">
				                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20"
				                                        aria-valuemin="0" aria-valuemax="100" style="width: '.round(($two_star*100)/$total_count_star,2).'%">
				                                        <span class="sr-only">'.round(($two_star*100)/$total_count_star,2).'%</span>
				                                    </div>
				                                </div>
				                            </div>
				                            <!-- end 2 -->
				                            <div class="col-xs-3 col-md-3 text-right">
				                                <span class="glyphicon glyphicon-star"></span>1
				                            </div>
				                            <div class="col-xs-8 col-md-9">
				                                <div class="progress">
				                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
				                                        aria-valuemin="0" aria-valuemax="100" style="width: '.round(($one_star*100)/$total_count_star,2).'%">
				                                        <span class="sr-only">'.round(($one_star*100)/$total_count_star,2).'%</span>
				                                    </div>
				                                </div>
				                            </div>
				                            <!-- end 1 -->
				                        </div>
				                        <!-- end row -->
				                    </div>
				                </div>
				            
           		</div>
				<div class="row">
				<div class="col-md-6">
						'.$this->render("review_block",["review_details"=>$review_details,'full_name'=>$full_name]).'
						</div>
				</div>

				        
			</div>	
    	</div> 
',
       
    ],
];
echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false
]);
?>
<br>							<!-- product tab info -->
								
								<!-- block-related product -->
								<div class="block-related ">
									<div class="block-title">
										<strong class="title">RELATED products</strong>
									</div>
									<div class="block-content ">
										<ol class="product-items owl-carousel " data-nav="true" data-dots="false" data-margin="30" data-responsive='{"0":{"items":1},"480":{"items":2},"600":{"items":3},"992":{"items":3}}'>
											
											
											<li class="product-item product-item-opt-2">
												<div class="product-item-info">
													<div class="product-item-photo">
														<a href="" class="product-item-img"><img src="<?= $path?>/images/p07.jpg" alt="product name"></a>
														<div class="product-item-actions">
															<a href="" class="btn btn-wishlist"><span>wishlist</span></a>
															<a href="" class="btn btn-compare"><span>compare</span></a>
															<a href="" class="btn btn-quickview"><span>quickview</span></a>
														</div>
														<button class="btn btn-cart" type="button"><span>Add to Cart</span></button>
														
													</div>
													<div class="product-item-detail">
														<strong class="product-item-name"><a href="">Brown Short 100% Cotton</a></strong>
														<div class="clearfix">
															<div class="product-item-price">
																<span class="price">Rs.45.00</span>
																<span class="old-price">Rs.52.00</span>
															</div>
															<div class="product-reviews-summary">
																<div class="rating-summary">
																	<div class="rating-result" title="70%">
																		<span style="width:70%">
																			<span><span>70</span>% of <span>100</span></span>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											
											<li class="product-item product-item-opt-2">
												<div class="product-item-info">
													<div class="product-item-photo">
														<a href="" class="product-item-img"><img src="<?= $path?>/images/p05.jpg" alt="product name"></a>
														<div class="product-item-actions">
															<a href="" class="btn btn-wishlist"><span>wishlist</span></a>
															<a href="" class="btn btn-compare"><span>compare</span></a>
															<a href="" class="btn btn-quickview"><span>quickview</span></a>
														</div>
														<button class="btn btn-cart" type="button"><span>Add to Cart</span></button>
														
													</div>
													<div class="product-item-detail">
														<strong class="product-item-name"><a href="">Summer T-Shirt</a></strong>
														<div class="clearfix">
															<div class="product-item-price">
																<span class="price">Rs.45.00</span>
																<span class="old-price">Rs.52.00</span>
															</div>
															<div class="product-reviews-summary">
																<div class="rating-summary">
																	<div class="rating-result" title="70%">
																		<span style="width:70%">
																			<span><span>70</span>% of <span>100</span></span>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li class="product-item product-item-opt-2">
												<div class="product-item-info">
													<div class="product-item-photo">
														<a href="" class="product-item-img"><img src="<?= $path?>/images/p03.jpg" alt="product name"></a>
														<div class="product-item-actions">
															<a href="" class="btn btn-wishlist"><span>wishlist</span></a>
															<a href="" class="btn btn-compare"><span>compare</span></a>
															<a href="" class="btn btn-quickview"><span>quickview</span></a>
														</div>
														<button class="btn btn-cart" type="button"><span>Add to Cart</span></button>
														
													</div>
													<div class="product-item-detail">
														<strong class="product-item-name"><a href="">Blue Short 50% Cotton</a></strong>
														<div class="clearfix">
															<div class="product-item-price">
																<span class="price">Rs.45.00</span>
																<span class="old-price">Rs.52.00</span>
															</div>
															<div class="product-reviews-summary">
																<div class="rating-summary">
																	<div class="rating-result" title="70%">
																		<span style="width:70%">
																			<span><span>70</span>% of <span>100</span></span>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li class="product-item product-item-opt-2">
												<div class="product-item-info">
													<div class="product-item-photo">
														<a href="" class="product-item-img"><img src="<?= $path?>/images/p06.jpg" alt="product name"></a>
														<div class="product-item-actions">
															<a href="" class="btn btn-wishlist"><span>wishlist</span></a>
															<a href="" class="btn btn-compare"><span>compare</span></a>
															<a href="" class="btn btn-quickview"><span>quickview</span></a>
														</div>
														<button class="btn btn-cart" type="button"><span>Add to Cart</span></button>
														
													</div>
													<div class="product-item-detail">
														<strong class="product-item-name"><a href="">Brown Short 100% Cotton</a></strong>
														<div class="clearfix">
															<div class="product-item-price">
																<span class="price">Rs.45.00</span>
																<span class="old-price">Rs.52.00</span>
															</div>
															<div class="product-reviews-summary">
																<div class="rating-summary">
																	<div class="rating-result" title="70%">
																		<span style="width:70%">
																			<span><span>70</span>% of <span>100</span></span>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											
										</ol>
									</div>
								</div><!-- block-related product -->
								
								<!-- block-Upsell Products -->
								<div class="block-upsell ">
									<div class="block-title">
										<strong class="title">You might also like</strong>
									</div>
									<div class="block-content ">
										<ol class="product-items owl-carousel " data-nav="true" data-dots="false" data-margin="30" data-responsive='{"0":{"items":1},"480":{"items":2},"600":{"items":3},"992":{"items":3}}'>
											
											
											<li class="product-item product-item-opt-2">
												<div class="product-item-info">
													<div class="product-item-photo">
														<a href="" class="product-item-img"><img src="<?= $path?>/images/p11.jpg" alt="product name"></a>
														<div class="product-item-actions">
															<a href="" class="btn btn-wishlist"><span>wishlist</span></a>
															<a href="" class="btn btn-compare"><span>compare</span></a>
															<a href="" class="btn btn-quickview"><span>quickview</span></a>
														</div>
														<button class="btn btn-cart" type="button"><span>Add to Cart</span></button>
													</div>
													<div class="product-item-detail">
														<strong class="product-item-name"><a href="">Leather Swiss Watch</a></strong>
														<div class="clearfix">
															<div class="product-item-price">
																<span class="price">Rs.45.00</span>
																<span class="old-price">Rs.52.00</span>
															</div>
															<div class="product-reviews-summary">
																<div class="rating-summary">
																	<div class="rating-result" title="70%">
																		<span style="width:70%">
																			<span><span>70</span>% of <span>100</span></span>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											
											<li class="product-item product-item-opt-2">
												<div class="product-item-info">
													<div class="product-item-photo">
														<a href="" class="product-item-img"><img src="<?= $path?>/images/p10.jpg" alt="product name"></a>
														<div class="product-item-actions">
															<a href="" class="btn btn-wishlist"><span>wishlist</span></a>
															<a href="" class="btn btn-compare"><span>compare</span></a>
															<a href="" class="btn btn-quickview"><span>quickview</span></a>
														</div>
														<button class="btn btn-cart" type="button"><span>Add to Cart</span></button>
														
													</div>
													<div class="product-item-detail">
														<strong class="product-item-name"><a href="">Sport T-Shirt For Men</a></strong>
														<div class="clearfix">
															<div class="product-item-price">
																<span class="price">Rs.45.00</span>
																<span class="old-price">Rs.52.00</span>
															</div>
															<div class="product-reviews-summary">
																<div class="rating-summary">
																	<div class="rating-result" title="70%">
																		<span style="width:70%">
																			<span><span>70</span>% of <span>100</span></span>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li class="product-item product-item-opt-2">
												<div class="product-item-info">
													<div class="product-item-photo">
														<a href="" class="product-item-img"><img src="<?= $path?>/images/p08.jpg" alt="product name"></a>
														<div class="product-item-actions">
															<a href="" class="btn btn-wishlist"><span>wishlist</span></a>
															<a href="" class="btn btn-compare"><span>compare</span></a>
															<a href="" class="btn btn-quickview"><span>quickview</span></a>
														</div>
														<button class="btn btn-cart" type="button"><span>Add to Cart</span></button>
														
													</div>
													<div class="product-item-detail">
														<strong class="product-item-name"><a href="">Fashion Leather Handbag</a></strong>
														<div class="clearfix">
															<div class="product-item-price">
																<span class="price">Rs.45.00</span>
																<span class="old-price">Rs.52.00</span>
															</div>
															<div class="product-reviews-summary">
																<div class="rating-summary">
																	<div class="rating-result" title="70%">
																		<span style="width:70%">
																			<span><span>70</span>% of <span>100</span></span>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											<li class="product-item product-item-opt-2">
												<div class="product-item-info">
													<div class="product-item-photo">
														<a href="" class="product-item-img"><img src="<?= $path?>/images/p04.jpg" alt="product name"></a>
														<div class="product-item-actions">
															<a href="" class="btn btn-wishlist"><span>wishlist</span></a>
															<a href="" class="btn btn-compare"><span>compare</span></a>
															<a href="" class="btn btn-quickview"><span>quickview</span></a>
														</div>
														<button class="btn btn-cart" type="button"><span>Add to Cart</span></button>
														
													</div>
													<div class="product-item-detail">
														<strong class="product-item-name"><a href="">Fashion Leather Handbag</a></strong>
														<div class="clearfix">
															<div class="product-item-price">
																<span class="price">Rs.45.00</span>
																<span class="old-price">Rs.52.00</span>
															</div>
															<div class="product-reviews-summary">
																<div class="rating-summary">
																	<div class="rating-result" title="70%">
																		<span style="width:70%">
																			<span><span>70</span>% of <span>100</span></span>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</li>
											
										</ol>
									</div>
								</div><!-- block-Upsell Products -->
						</div>
					</div>
				</main><!-- end MAIN -->
<?php
$js = <<<JS
$(document).ready(function() {
	 $("#open-review-box").click(function(){
        $("#post-review-box").slideToggle();
    });

    $("#close-review-box").click(function(){
        $("#post-review-box").slideUp();
    });
});
JS;
echo $this->registerJs($js);
?>
<?php
use yii\helpers\Url;
$sub_category=$this->params['sub_category'][$cat_id['cat_id']];
$path = Yii::$app->request->baseUrl;
?>
<main class="site-main" >

				<div class="columns container">
					<!-- Block  Breadcrumb-->
					<div class="row">
						
						<!-- Main Content -->
						<div class="col-md-12 col-sm-12 col-main">
							
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
										<a href=""><img src="<?= $path?>/images/cat-top1.jpg" class="img-responsive" alt="category-images"></a>
									</div>
									<div class="item " >
										<a href=""><img src="<?= $path?>/images/cat-top1.jpg" class="img-responsive" alt="category-images"></a>
									</div>
								</div>
							</div><!-- images categori -->
							
							<!-- Toolbar -->
							<div class=" toolbar-products toolbar-top" style="border-bottom: none;">
							</div><!-- Toolbar -->
							
							<!-- List Products -->
							<div class="products  products-grid" id="ajaxchange">
							<!--product -->
							<div class="row">
							<?php foreach ($sub_category as $x):?>
							<a class="col-md-3" href="<?= Url::ToRoute(['shop/'.$slug.'/'.$x['slug']])?>">
							<div class="product-category-sec__1">
							  <img src="<?= $path?>/images/p01.jpg" alt="Avatar" class="product-image-category-name-sec__1 img-responsive" style="width:100%">
							  <div class="product-show-category-name-sec__1">
							    <div class="product-category-name-text-sec__1"><?= $x['name']?></div>
							  </div>
							</div>
							</a>
						<?php endforeach;?>
						</div>
						

							
						</div><!-- Main Content -->
						
						
						
						
					</div>
				</div>
				
				
			</main><!-- end MAIN -->
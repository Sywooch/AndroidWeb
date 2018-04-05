<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use common\models\Product;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\models\Image;

$path = Yii::$app->request->baseUrl;
?>

<?php $prdt_id = $model['prdt_id'];?>
<?php
   $prdt = new Product;
   $slug_value = $prdt->getParentSlug($prdt_id);
 ?>
							
										<div class="product-item-opt-1 col-sm-3" style="height:250px;width: 233px;margin-top: 50px;margin-bottom: 70px;margin-left: 30px;">
											<div class="product-item-info">
												<div class="product-item-photo" style="border: 1px solid #dedfe0;">
													<a href="<?php echo Url::toRoute(['shop/'.$slug_value.'/'.$model['slug']])?>" class="product-item-img">
                                                    <?php if($model['image']==0):?>
                                                        <?php
                                                            $category_id = $model['cat_id'];
                                                            $image_details = Image::find()->where(['type'=>2,'r_id'=>$category_id])->one();
                                                        ?>
                                                        <?php if(empty($image_details)):?>
                                                             <img src="<?= $path?>/images/p02.jpg" alt="product name">
                                                        <?php endif;?>
                                                        <?php if(!empty($image_details)):?>
                                                            <?= Html::img($path.'/'.$image_details['name'], ['alt' =>$image_details['caption']]) ?>
                                                        <?php endif;?>

                                                     <?php endif;?>
                                                    <?php if($model['image'] !=0):?>
                                                <?php
                                                    $prdt_id = $model['prdt_id'];
                                                    $image_details = Image::findOne($model['image']);
                                                ?>
                                                        <?= Html::img($path.'/'.$image_details['name'], ['alt' =>$image_details['caption']]) ?>
                                                    <?php endif;?>
                                                    </a>
													<div class="product-item-actions">
														<a href="wishlist.php" class="btn btn-wishlist"><span>wishlist</span></a>
														<a href="compare.php" class="btn btn-compare"><span>compare</span></a>
														<a href="product.php" class="btn btn-quickview"><span>quickview</span></a>
													</div>
													
													 <input type="hidden" id="hid1" value="<?php echo Url::toRoute(['site/auto-refresh-cart'])?>" name="">
                                        <?= Html::Button('<span>Add to Cart</span>', ['class' => 'btn btn-cart','id'=>'addtocart','value'=>$model['prdt_id'],'onclick'=>'
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
												</div>
												<?php if($model['discount'] != 0):?>
                                    <span class="product-item-label label-price"><?= $model['discount']?>% <span>off</span></span>
                                <?php endif;?>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href=""><?= $model['name']?></a></strong>
                                        <?php if($model['discount'] != 0):?>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.<?= $model['price']-(($model['discount']*$model['price'])/100);?></span>
                                                <span class="old-price">Rs. <?= $model['price']?></span>
                                            </div>
                                        </div>
                                    <?php endif?>
                                    <?php if($model['discount'] == 0):?>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs. <?= $model['price']?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    </div>
											</div>
										</div>
				

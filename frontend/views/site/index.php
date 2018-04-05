<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Product;
use common\models\Image;
$this->title = 'Home';
$path = Yii::$app->request->baseUrl;
?>
        <div class="wrapper">
        <!-- alert banner top -->      
            
            <!-- MAIN -->
            <main class="site-main">
               <div class="block-section-top block-section-top2">
    <div class="container">
        <div class="box-section-top">
            
            <!-- categori -->
            <div class="block-nav-categori">
                
                <div class="block-title">
                    <span>Categories</span>
                </div>
                
                <div class="block-content">
                    <ul class="ui-categori">
                        <?php $y = 0;?>
                        <?php foreach($this->params['categories'] as $category):?>
                            <?php $x = $y>10?'cat-link-orther':''?>
                        <li class="parent <?= $x; ?>">
                            <a href="<?= Url::toRoute(['shop/'.$category['slug']])?>">
                                <span class="icon"><img src="<?= $path?>/images/nav-cat1.png" alt="nav-cat"></span>
                                <?= $category['name']?>
                            </a>
                            <?php if(!empty($this->params['sub_category'][$category['cat_id']])):?>
                            <span class="toggle-submenu"></span>
                            <div class="submenu">
                                <ul class="categori-list clearfix row">
                                    <li class="col-sm-3 col-md-4">
                                        <strong class="title"><a href="<?= Url::toRoute(['shop/'.$category['slug']])?>"><?= $category['name']?></a></strong>
                                        <ul>
                                            <?php foreach($this->params['sub_category'][$category['cat_id']] as $x):?>
                                            <li><a href="<?= Url::toRoute(['shop/'.$category['slug'].'/'.$x['slug']])?>"><?= $x['name']?></a></li>
                                        <?php endforeach;?>
                                        </ul>
                                    </li>
                                    <li class="col-md-8">
                                    <?php
                                        $category_id = $category['cat_id'];
                                         $image_details = Image::find()->where(['type'=>2,'r_id'=>$category_id])->one();
                                    ?>
                                    <?= Html::img($path.'/'.$image_details['name'], ['alt' =>$image_details['caption']]) ?>
                                    </li>
                                </ul>
                            </div>
                        <?php endif;?>
                        </li>
                        <?php $y++;?>
                    <?php endforeach;?>                      
                    </ul>
                    
                    <div class="view-all-categori">
                        <a  class="open-cate btn-view-all">All Categories</a>
                    </div>
                </div>
                
            </div><!-- categori -->
            
            <!-- block slide top -->
            <div class="block-slide-main slide-opt-2">
                
                <!-- slide -->
                <div class="owl-carousel " 
                data-nav="true" 
                data-dots="false" 
                data-margin="0" 
                data-items='1' 
                data-autoplayTimeout="700" 
                data-autoplay="true" 
                data-loop="true">
                    <div class="item item2" >
                        <a href="" class="img-slide"><img src="<?= $path?>/images/sb00.jpg" alt="img"></a>
                    </div>
                    
                    <div class="item item1" >
                        <a href="" class="img-slide"><img src="<?= $path?>/images/sb01.jpg" alt="img"></a>
                    </div>
                    
                    <div class="item item3" >
                        <a href="" class="img-slide"><img src="<?= $path?>/images/sb02.jpg" alt="img"></a>
                    </div>
                    <div class="item item4" >
                        <a href="" class="img-slide"><img src="<?= $path?>/images/sb03.jpg" alt="img"></a>
                    </div>
                </div> <!-- slide -->
                
            </div><!-- block slide top -->
            
            
        </div>
    </div>
</div>
                
              <!--   //hot deals start -->
<div class="block-hot-deals-opt3">
    <div class="container">
        
        <div class="box-content">
            
            <div class="block-title">
                <span class="title"><span>H<br>o<br>t</span><span>d<br>e<br>a<br>l<br>s</span></span>
                
                <div class="nav-links dropdown">
                    <button class="dropdown-toggle"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu" >
                        <ul  >
                            <li role="presentation" class="active"><a href="#hot-1"  role="tab" data-toggle="tab">Deal Of The Day</a></li>
                            <li role="presentation" class=""><a href="#hot-2"  role="tab" data-toggle="tab">Best Offers</a></li>
                            <li role="presentation" class=""><a href="#hot-3"  role="tab" data-toggle="tab">Best Sellers</a></li>
                            <li role="presentation" class=""><a href="#hot-4"  role="tab" data-toggle="tab">Highest Rated</a></li>
                            <li role="presentation" class=""><a href="#hot-5"  role="tab" data-toggle="tab">Clearing Fast</a></li>
                        </ul>
                    </div>
                </div>
                
            </div>
            
            <div class="block-content ">
                
                <div class="tab-content">
                    
                    <div class="tab-pane active in  fade " id="hot-1" role="tabpanel">
                        
                        <div class="owl-carousel" 
                        data-nav="true" 
                        data-dots="false" 
                        data-margin="30" 
                        data-responsive='{
                        "0":{"items":1},
                        "480":{"items":2},
                        "480":{"items":2},
                        "768":{"items":3},
                        "992":{"items":3},
                        "1200":{"items":4}
                        }'>
                            
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <a class="product-item-img" href=""><img alt="product name" src="images/p01.jpg"></a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <button type="button" class="btn btn-cart"><span>Add to Cart</span></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href="">Maecenas consequat </a></strong>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.45.00</span>
                                                <span class="old-price">Rs.52.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <a class="product-item-img" href=""><img alt="product name" src="images/p02.jpg"></a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <button type="button" class="btn btn-cart"><span>Add to Cart</span></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href="">Maecenas consequat </a></strong>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.45.00</span>
                                                <span class="old-price">Rs.52.00</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <a class="product-item-img" href=""><img alt="product name" src="images/p03.jpg"></a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <button type="button" class="btn btn-cart"><span>Add to Cart</span></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href="">Maecenas consequat </a></strong>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.45.00</span>
                                                <span class="old-price">Rs.52.00</span>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <a class="product-item-img" href=""><img alt="product name" src="images/p04.jpg"></a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <button type="button" class="btn btn-cart"><span>Add to Cart</span></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href="">Maecenas consequat </a></strong>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.45.00</span>
                                                <span class="old-price">Rs.52.00</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <a class="product-item-img" href=""><img alt="product name" src="images/p05.jpg"></a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <button type="button" class="btn btn-cart"><span>Add to Cart</span></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href="">Maecenas consequat </a></strong>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.45.00</span>
                                                <span class="old-price">Rs.52.00</span>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="tab-pane fade " id="hot-2" role="tabpanel">
                        
                        <div class="owl-carousel" 
                        data-nav="true" 
                        data-dots="false" 
                        data-margin="30" 
                        data-responsive='{
                        "0":{"items":1},
                        "480":{"items":2},
                        "480":{"items":2},
                        "768":{"items":3},
                        "992":{"items":3},
                        "1200":{"items":4}
                        }'>
                            
                           <!--  <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <a class="product-item-img" href=""><img alt="product name" src="images/p06.jpg"></a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <button type="button" class="btn btn-cart"><span>Add to Cart</span></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href="">Maecenas consequat </a></strong>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.45.00</span>
                                                <span class="old-price">Rs.52.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                             <?php $y=0;?>
                            <?php foreach ($products as $product) : ?>
                                <?php $prdt_id = $product['prdt_id'];?>
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <?php
                                        $prdt = new Product;
                                        $slug_value = $prdt->getParentSlug($prdt_id);
                                        //echo $slug_value;
                                        ?>
                                        <a class="product-item-img" href="<?php echo Url::toRoute(['shop/'.$slug_value.'/'.$product['slug']])?>">
                                            <?php if($product['image']==0):?>
                                            <?php
                                                $category_id = $product['cat_id'];
                                                $image_details = Image::find()->where(['type'=>2,'r_id'=>$category_id])->one();
                                            ?>
                                            <?php if(empty($image_details)):?>
                                                 <img src="<?= $path?>/images/p01.jpg" alt="product name">
                                            <?php endif;?>
                                             <?php if(!empty($image_details)):?>
                                                <?= Html::img($path.'/'.$image_details['name'], ['alt' =>$image_details['caption']]) ?>
                                            <?php endif;?>

                                            <?php endif;?>
                                            <?php if($product['image'] !=0):?>
                                                <?php
                                                    $prdt_id = $product['prdt_id'];
                                                    $image_details = Image::findOne($product['image']);
                                                ?>
                                                        <?= Html::img($path.'/'.$image_details['name'], ['alt' =>$image_details['caption']]) ?>
                                            <?php endif;?>

                                        </a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <input type="hidden" id="hid1" value="<?php echo Url::toRoute(['site/auto-refresh-cart'])?>" name="">
                                        <?= Html::Button('<span>Add to Cart</span>', ['class' => 'btn btn-cart','id'=>'addtocart','value'=>$product['prdt_id'],'onclick'=>'
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
                                    <?php if($product['discount'] != 0):?>
                                    <span class="product-item-label label-price"><?= $product['discount']?>% <span>off</span></span>
                                <?php endif;?>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href=""><?= $product['name']?></a></strong>
                                        <?php if($product['discount'] != 0):?>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.<?= $product['price']-(($product['discount']*$product['price'])/100);?></span>
                                                <span class="old-price">Rs. <?= $product['price']?></span>
                                            </div>
                                        </div>
                                    <?php endif?>
                                    <?php if($product['discount'] == 0):?>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs. <?= $product['price']?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php $y++;?>
                        <?php endforeach;?>

                        </div>
                    </div>
                    
                    <div class="tab-pane  fade " id="hot-3" role="tabpanel">
                        
                        <div class="owl-carousel" 
                        data-nav="true" 
                        data-dots="false" 
                        data-margin="30" 
                        data-responsive='{
                        "0":{"items":1},
                        "480":{"items":2},
                        "480":{"items":2},
                        "768":{"items":3},
                        "992":{"items":3},
                        "1200":{"items":4}
                        }'>
                            
                              <?php $y=0;?>
                            <?php foreach ($sold_products as $product) : ?>
                                <?php $prdt_id = $product['prdt_id'];?>
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <?php
                                        $prdt = new Product;
                                        $slug_value = $prdt->getParentSlug($prdt_id);
                                        //echo $slug_value;
                                        ?>
                                        <a class="product-item-img" href="<?php echo Url::toRoute(['shop/'.$slug_value.'/'.$product['slug']])?>">
                                         <?php if($product['image']==0):?>
                                            <?php
                                                $category_id = $product['cat_id'];
                                                $image_details = Image::find()->where(['type'=>2,'r_id'=>$category_id])->one();
                                            ?>
                                            <?php if(empty($image_details)):?>
                                                 <img src="<?= $path?>/images/p01.jpg" alt="product name">
                                            <?php endif;?>
                                             <?php if(!empty($image_details)):?>
                                                <?= Html::img($path.'/'.$image_details['name'], ['alt' =>$image_details['caption']]) ?>
                                            <?php endif;?>

                                            <?php endif;?>
                                            <?php if($product['image'] !=0):?>
                                                <?php
                                                    $prdt_id = $product['prdt_id'];
                                                    $image_details = Image::findOne($product['image']);
                                                ?>
                                                        <?= Html::img($path.'/'.$image_details['name'], ['alt' =>$image_details['caption']]) ?>
                                            <?php endif;?>
                                        </a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <input type="hidden" id="hid1" value="<?php echo Url::toRoute(['site/auto-refresh-cart'])?>" name="">
                                        <?= Html::Button('<span>Add to Cart</span>', ['class' => 'btn btn-cart','id'=>'addtocart','value'=>$product['prdt_id'],'onclick'=>'
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
                                     <?php if($product['discount'] != 0):?>
                                    <span class="product-item-label label-price"><?= $product['discount']?>% <span>off</span></span>
                                <?php endif;?>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href=""><?= $product['name']?></a></strong>
                                        <?php if($product['discount'] != 0):?>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.<?= $product['price']-(($product['discount']*$product['price'])/100);?></span>
                                                <span class="old-price">Rs. <?= $product['price']?></span>
                                            </div>
                                        </div>
                                    <?php endif?>
                                    <?php if($product['discount'] == 0):?>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs. <?= $product['price']?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php $y++;?>
                        <?php endforeach;?>
                            
                        </div>
                    </div>
                    
                    <div class="tab-pane  fade " id="hot-4" role="tabpanel">
                        
                        <div class="owl-carousel" 
                        data-nav="true" 
                        data-dots="false" 
                        data-margin="30" 
                        data-responsive='{
                        "0":{"items":1},
                        "480":{"items":2},
                        "480":{"items":2},
                        "768":{"items":3},
                        "992":{"items":3},
                        "1200":{"items":4}
                        }'>
                            
                            <?php $y=0;?>
                            <?php foreach ($sold_products as $product) : ?>
                                <?php $prdt_id = $product['prdt_id'];?>
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <?php
                                        $prdt = new Product;
                                        $slug_value = $prdt->getParentSlug($prdt_id);
                                        //echo $slug_value;
                                        ?>
                                        <a class="product-item-img" href="<?php echo Url::toRoute(['shop/'.$slug_value.'/'.$product['slug']])?>">
                                         <?php if($product['image']==0):?>
                                            <?php
                                                $category_id = $product['cat_id'];
                                                $image_details = Image::find()->where(['type'=>2,'r_id'=>$category_id])->one();
                                            ?>
                                            <?php if(empty($image_details)):?>
                                                 <img src="<?= $path?>/images/p01.jpg" alt="product name">
                                            <?php endif;?>
                                             <?php if(!empty($image_details)):?>
                                                <?= Html::img($path.'/'.$image_details['name'], ['alt' =>$image_details['caption']]) ?>
                                            <?php endif;?>

                                            <?php endif;?>
                                            <?php if($product['image'] !=0):?>
                                                <?php
                                                    $prdt_id = $product['prdt_id'];
                                                    $image_details = Image::findOne($product['image']);
                                                ?>
                                                        <?= Html::img($path.'/'.$image_details['name'], ['alt' =>$image_details['caption']]) ?>
                                            <?php endif;?>
                                        </a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <input type="hidden" id="hid1" value="<?php echo Url::toRoute(['site/auto-refresh-cart'])?>" name="">
                                        <?= Html::Button('<span>Add to Cart</span>', ['class' => 'btn btn-cart','id'=>'addtocart','value'=>$product['prdt_id'],'onclick'=>'
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
                                     <?php if($product['discount'] != 0):?>
                                    <span class="product-item-label label-price"><?= $product['discount']?>% <span>off</span></span>
                                <?php endif;?>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href=""><?= $product['name']?></a></strong>
                                        <?php if($product['discount'] != 0):?>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.<?= $product['price']-(($product['discount']*$product['price'])/100);?></span>
                                                <span class="old-price">Rs. <?= $product['price']?></span>
                                            </div>
                                        </div>
                                    <?php endif?>
                                    <?php if($product['discount'] == 0):?>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs. <?= $product['price']?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php $y++;?>
                        <?php endforeach;?>
                            
                        </div>
                    </div>
                    
                    <div class="tab-pane  fade " id="hot-5" role="tabpanel">
                        
                        <div class="owl-carousel" 
                        data-nav="true" 
                        data-dots="false" 
                        data-margin="30" 
                        data-responsive='{
                        "0":{"items":1},
                        "480":{"items":2},
                        "480":{"items":2},
                        "768":{"items":3},
                        "992":{"items":3},
                        "1200":{"items":4}
                        }'>
                            
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <a class="product-item-img" href=""><img alt="product name" src="images/p02.jpg"></a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <button type="button" class="btn btn-cart"><span>Add to Cart</span></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href="">Maecenas consequat </a></strong>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.45.00</span>
                                                <span class="old-price">Rs.52.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <a class="product-item-img" href=""><img alt="product name" src="images/p04.jpg"></a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <button type="button" class="btn btn-cart"><span>Add to Cart</span></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href="">Maecenas consequat </a></strong>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.45.00</span>
                                                <span class="old-price">Rs.52.00</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <a class="product-item-img" href=""><img alt="product name" src="images/p06.jpg"></a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <button type="button" class="btn btn-cart"><span>Add to Cart</span></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href="">Maecenas consequat </a></strong>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.45.00</span>
                                                <span class="old-price">Rs.52.00</span>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <a class="product-item-img" href=""><img alt="product name" src="images/p08.jpg"></a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <button type="button" class="btn btn-cart"><span>Add to Cart</span></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href="">Maecenas consequat </a></strong>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.45.00</span>
                                                <span class="old-price">Rs.52.00</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-item  product-item-opt-1 ">
                                <div class="product-item-info">
                                    <div class="product-item-photo">
                                        <a class="product-item-img" href=""><img alt="product name" src="images/p10.jpg"></a>
                                        <div class="product-item-actions">
                                            <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                            <a class="btn btn-compare" href=""><span>compare</span></a>
                                            <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                        </div>
                                        <button type="button" class="btn btn-cart"><span>Add to Cart</span></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href="">Maecenas consequat </a></strong>
                                        <div class="clearfix">
                                            <div class="product-item-price">
                                                <span class="price">Rs.45.00</span>
                                                <span class="old-price">Rs.52.00</span>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
    </div>
</div>
               <!--  //hot deals end -->
                
                
                <div class="clearfix" style="background-color: #eeeeee;margin-bottom: 30px; padding-top:30px;">
                    
                    
                </div>
                
                <!-- Banner -->
                <div class="block-banner-floor effect-banner2 ">
                    <div class="container">
                        <div class="clearfix">
                            <div class="col-sm-6 no-padding">
                                <a href="" class="box-img"><img src="<?= $path?>/images/banner1-1.jpg" alt="banner"></a>
                            </div>
                            <div class="col-sm-6 no-padding">
                                <a href="" class="box-img"><img src="<?= $path?>/images/banner1-2.jpg" alt="banner"></a>
                            </div>
                        </div>
                    </div>
                </div><!-- Banner -->
                <div class="row">
                <br>
                </div>
                
                <!-- show categori +img -->
                <div class="block-categori-opt12 style-opt13">
                    <div class="container">
                        
                        <!--Start Row 1-->
                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="item item1" style="background-image: url(<?= $path?>/images/cat01.jpg);">
                                    <div class="title">
                                        <span>Shop for </span>
                                        <strong class="sub-title">Access -ories</strong>
                                    </div>
                                    <ul class="list-cat">
                                        <li><a href="">Car Care</a></li>
                                        <li><a href="">Door Wisor</a></li>
                                        <li><a href="">Mud Flap</a></li>
                                        <li><a href="">Seat Cover</a></li>
                                        <li><a href="">Floor Mats</a></li>
                                        <li><a href="">Cabin</a></li>
                                        <li><a href="">Wipers</a></li>
                                    </ul>
                                    <div class="actions">
                                        <a href="" class="btn-view">View all</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="item item1" style="background-image: url(<?= $path?>/images/cat02.jpg);">
                                    <div class="title">
                                        <span>Shop for </span>
                                        <strong class="sub-title">Body Parts</strong>
                                    </div>
                                    <ul class="list-cat">
                                        <li><a href="">Car Care</a></li>
                                        <li><a href="">Door Wisor</a></li>
                                        <li><a href="">Mud Flap</a></li>
                                        <li><a href="">Seat Cover</a></li>
                                        <li><a href="">Floor Mats</a></li>
                                        <li><a href="">Cabin</a></li>
                                        <li><a href="">Wipers</a></li>
                                    </ul>
                                    <div class="actions">
                                        <a href="" class="btn-view">View all</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="item item1" style="background-image: url(<?= $path?>/images/cat03.jpg);">
                                    <div class="title">
                                        <span>Shop for </span>
                                        <strong class="sub-title">Engine Parts</strong>
                                    </div>
                                    <ul class="list-cat">
                                        <li><a href="">Car Care</a></li>
                                        <li><a href="">Door Wisor</a></li>
                                        <li><a href="">Mud Flap</a></li>
                                        <li><a href="">Seat Cover</a></li>
                                        <li><a href="">Floor Mats</a></li>
                                        <li><a href="">Cabin</a></li>
                                        <li><a href="">Wipers</a></li>
                                    </ul>
                                    <div class="actions">
                                        <a href="" class="btn-view">View all</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        <!--END Row 1-->
                        <!--Start Row 2-->
                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="item item1" style="background-image: url(<?= $path?>/images/cat02.jpg);">
                                    <div class="title">
                                        <span>Shop for </span>
                                        <strong class="sub-title">Trans-mission</strong>
                                    </div>
                                    <ul class="list-cat">
                                        <li><a href="">Car Care</a></li>
                                        <li><a href="">Door Wisor</a></li>
                                        <li><a href="">Mud Flap</a></li>
                                        <li><a href="">Seat Cover</a></li>
                                        <li><a href="">Floor Mats</a></li>
                                        <li><a href="">Cabin</a></li>
                                        <li><a href="">Wipers</a></li>
                                    </ul>
                                    <div class="actions">
                                        <a href="" class="btn-view">View all</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="item item1" style="background-image: url(<?= $path?>/images/cat03.jpg);">
                                    <div class="title">
                                        <span>Shop for </span>
                                        <strong class="sub-title">Brake Parts</strong>
                                    </div>
                                    <ul class="list-cat">
                                        <li><a href="">Car Care</a></li>
                                        <li><a href="">Door Wisor</a></li>
                                        <li><a href="">Mud Flap</a></li>
                                        <li><a href="">Seat Cover</a></li>
                                        <li><a href="">Floor Mats</a></li>
                                        <li><a href="">Cabin</a></li>
                                        <li><a href="">Wipers</a></li>
                                    </ul>
                                    <div class="actions">
                                        <a href="" class="btn-view">View all</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="item item1" style="background-image: url(<?= $path?>/images/cat01.jpg);">
                                    <div class="title">
                                        <span>Shop for </span>
                                        <strong class="sub-title">Oil & Filters</strong>
                                    </div>
                                    <ul class="list-cat">
                                        <li><a href="">Car Care</a></li>
                                        <li><a href="">Door Wisor</a></li>
                                        <li><a href="">Mud Flap</a></li>
                                        <li><a href="">Seat Cover</a></li>
                                        <li><a href="">Floor Mats</a></li>
                                        <li><a href="">Cabin</a></li>
                                        <li><a href="">Wipers</a></li>
                                    </ul>
                                    <div class="actions">
                                        <a href="" class="btn-view">View all</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        <!--END Row 2-->
                        <!--Start Row 3-->
                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="item item1" style="background-image: url(<?= $path?>/images/cat03.jpg);">
                                    <div class="title">
                                        <span>Shop for </span>
                                        <strong class="sub-title">Electronics</strong>
                                    </div>
                                    <ul class="list-cat">
                                        <li><a href="">Car Care</a></li>
                                        <li><a href="">Door Wisor</a></li>
                                        <li><a href="">Mud Flap</a></li>
                                        <li><a href="">Seat Cover</a></li>
                                        <li><a href="">Floor Mats</a></li>
                                        <li><a href="">Cabin</a></li>
                                        <li><a href="">Wipers</a></li>
                                    </ul>
                                    <div class="actions">
                                        <a href="" class="btn-view">View all</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="item item1" style="background-image: url(<?= $path?>/images/cat01.jpg);">
                                    <div class="title">
                                        <span>Shop for </span>
                                        <strong class="sub-title">Music System</strong>
                                    </div>
                                    <ul class="list-cat">
                                        <li><a href="">Car Care</a></li>
                                        <li><a href="">Door Wisor</a></li>
                                        <li><a href="">Mud Flap</a></li>
                                        <li><a href="">Seat Cover</a></li>
                                        <li><a href="">Floor Mats</a></li>
                                        <li><a href="">Cabin</a></li>
                                        <li><a href="">Wipers</a></li>
                                    </ul>
                                    <div class="actions">
                                        <a href="" class="btn-view">View all</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="item item1" style="background-image: url(<?= $path?>/images/cat02.jpg);">
                                    <div class="title">
                                        <span>Shop for </span>
                                        <strong class="sub-title">Tool Kits</strong>
                                    </div>
                                    <ul class="list-cat">
                                        <li><a href="">Car Care</a></li>
                                        <li><a href="">Door Wisor</a></li>
                                        <li><a href="">Mud Flap</a></li>
                                        <li><a href="">Seat Cover</a></li>
                                        <li><a href="">Floor Mats</a></li>
                                        <li><a href="">Cabin</a></li>
                                        <li><a href="">Wipers</a></li>
                                    </ul>
                                    <div class="actions">
                                        <a href="" class="btn-view">View all</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        <!--END Row 3-->
                    </div>
                </div>
                <!-- show categori +img-->
                
                <!-- Banner -->
                <div class="block-banner-floor effect-banner2 ">
                    <div class="container">
                        <div class="clearfix">
                            <div class="col-sm-6 no-padding">
                                <a href="" class="box-img"><img src="<?= $path?>/images/banner1-3.jpg" alt="banner"></a>
                            </div>
                            <div class="col-sm-6 no-padding">
                                <a href="" class="box-img"><img src="<?= $path?>/images/banner1-4.jpg" alt="banner"></a>
                            </div>
                        </div>
                    </div>
                </div><!-- Banner -->
                
                <!-- Block Blog -->
                <div class="block-the-blog">
                    <div class="container">
                        <div class="block-title">
                            <span class="title">From The  Blog</span>
                        </div>
                        <div class="block-content">
                            <div class="owl-carousel" 
                            data-nav="true" 
                            data-dots="false" 
                            data-margin="30" 
                            data-responsive='{
                            "0":{"items":1},
                            "480":{"items":2},
                            "768":{"items":2},
                            "992":{"items":3},
                            "1200":{"items":4}
                            }'>
                                <div class="blog-item">
                                    <div class="blog-photo">
                                        <a href=""><img src="<?= $path?>/images/bp01.jpg" alt="blog"></a>
                                        
                                    </div>
                                    <div class="blog-detail">
                                        <strong class="blog-name"><a href="">Share the love for KuteShop </a></strong>
                                        <div class="blog-info">
                                            <div class="blog-date"><span>February 27, 2015</span></div>
                                            <div class="blog-comment"><span>27 comment</span></div>
                                        </div>
                                        <div class="blog-actions">
                                            <a href="" class="action">Read more</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="blog-item">
                                    <div class="blog-photo">
                                        <a href=""><img src="<?= $path?>/images/bp02.jpg" alt="blog"></a>
                                        
                                    </div>
                                    <div class="blog-detail">
                                        <strong class="blog-name"><a href="">Send your Question to Kuteshop </a></strong>
                                        <div class="blog-info">
                                            <div class="blog-date"><span>February 27, 2015</span></div>
                                            <div class="blog-comment"><span>27 comment</span></div>
                                        </div>
                                        <div class="blog-actions">
                                            <a href="" class="action">Read more</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="blog-item">
                                    <div class="blog-photo">
                                        <a href=""><img src="<?= $path?>/images/bp03.jpg" alt="blog"></a>
                                        
                                    </div>
                                    <div class="blog-detail">
                                        <strong class="blog-name"><a href="">The history the hype </a></strong>
                                        <div class="blog-info">
                                            <div class="blog-date"><span>February 27, 2015</span></div>
                                            <div class="blog-comment"><span>27 comment</span></div>
                                        </div>
                                        <div class="blog-actions">
                                            <a href="" class="action">Read more</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="blog-item">
                                    <div class="blog-photo">
                                        <a href=""><img src="<?= $path?>/images/bp04.jpg" alt="blog"></a>
                                        
                                    </div>
                                    <div class="blog-detail">
                                        <strong class="blog-name"><a href="">Collection Summer Fashion </a></strong>
                                        <div class="blog-info">
                                            <div class="blog-date"><span>February 27, 2015</span></div>
                                            <div class="blog-comment"><span>27 comment</span></div>
                                        </div>
                                        <div class="blog-actions">
                                            <a href="" class="action">Read more</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="blog-item">
                                    <div class="blog-photo">
                                        <a href=""><img src="<?= $path?>/images/bp01.jpg" alt="blog"></a>
                                        
                                    </div>
                                    <div class="blog-detail">
                                        <strong class="blog-name"><a href="">Share the love for KuteShop </a></strong>
                                        <div class="blog-info">
                                            <div class="blog-date"><span>February 27, 2015</span></div>
                                            <div class="blog-comment"><span>27 comment</span></div>
                                        </div>
                                        <div class="blog-actions">
                                            <a href="" class="action">Read more</a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div><!-- Block Blog -->
                
                <!--  block-service-->
                <div class="block-service-opt2">
                    <div class="container">
                        <div class="items">
                            <div class="item">
                                <div class="icon">
                                    <img src="<?= $path?>/images/service04.png" alt="service">
                                    <span class="title">Great Value</span>
                                </div>
                                <div class="des">
                                    We offer competitive prices on our 100 million plus product range.
                                </div>
                            </div>
                            <div class="item">
                                <div class="icon">
                                    <img src="<?= $path?>/images/service06.png" alt="service">
                                    <span class="title">Worldwide Delivery</span>
                                </div>
                                <div class="des">
                                    With sites in 5 languages, we ship to over 200 countries & regions.
                                </div>
                            </div>
                            <div class="item">
                                <div class="icon">
                                    <img src="<?= $path?>/images/service05.png" alt="service">
                                    <span class="title">Safe Payment</span>
                                </div>
                                <div class="des">
                                    Pay with the world's most popular and secure payment methods.
                                </div>
                            </div>
                            
                            <div class="item">
                                <div class="icon">
                                    <img src="<?= $path?>/images/service03.png" alt="service">
                                    <span class="title">Easy Return</span>
                                </div>
                                <div class="des">
                                    Our Buyer Protection covers your purchase from click to delivery.
                                </div>
                            </div>
                            <div class="item">
                                <div class="icon">
                                    <img src="<?= $path?>/images/service01.png" alt="service">
                                    <span class="title">24/7 Help Center</span>
                                </div>
                                <div class="des">
                                    Round-the-clock assistance for a smooth shopping experience.
                                </div>
                            </div>
                            <div class="item">
                                <div class="icon">
                                    <img src="<?= $path?>/images/service02.png" alt="service">
                                    <span class="title">Best Service</span>
                                </div>
                                <div class="des">
                                    Download the app and get the world of AliExpress at your fingertips.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  block-service-->
                
       

            <!-- Block Testimonials -->
            <div class="block-testimonials-opt8" style="background-image: url(<?= $path?>/images/bg-testimonials.jpg);">
                <div class="container">

                    <div class="block-title">
                        <span class="title">Testimonials</span>
                    </div>

                    <div class="block-content">

                        <div class="owl-carousel testimonials-thumb" 
                            data-loop="true"
                            data-center="true"
                            data-nav="false" 
                            data-dots="false" 
                            data-margin="35" 
                            data-autoplayTimeout="500" 
                            data-autoplay="true" 
                            data-responsive='{
                            "0":{"items":1},
                            "360":{"items":3},
                            "480":{"items":3},
                            "768":{"items":3},
                            "992":{"items":3},
                            "1200":{"items":3}
                            }'>
                       
                            <div class="item ">
                                <div class="photo">
                                    <span class="img"><img src="<?= $path?>/images/pr01.jpg" alt="img"></span>
                                </div>
                            </div>
                            <div class="item ">
                                <div class="photo">
                                    <span class="img"><img src="<?= $path?>/images/pr02.jpg" alt="img"></span>
                                    
                                </div>
                            </div>
                            <div class="item ">
                                <div class="photo">
                                    <span class="img"><img src="<?= $path?>/images/pr03.jpg" alt="img"></span>
                                </div>
                            </div>

                            <div class="item ">
                                <div class="photo">
                                    <span class="img"><img src="<?= $path?>/images/pr04.jpg" alt="img"></span>
                                </div>
                            </div>
                        </div>

                        <div class="owl-carousel testimonials-des" 
                            data-loop="true"
                            data-nav="false" 
                            data-dots="false" 
                            data-margin="0" 
                            data-responsive='{
                            "0":{"items":1},
                            "360":{"items":1},
                            "480":{"items":1},
                            "768":{"items":1},
                            "992":{"items":1},
                            "1200":{"items":1}
                            }'>
                            <div class="item">
                                
                                <div class="info">
                                    <p>We combine industry expertise with innovative technology to deliver critical information to leading decision makers , We combine industry expertise with innovative technology to deliver critical information to leading decision makers. Thank you very much for youe services!.</p>
                                    <p class="testimonial-nane">Karla Anderson - Happy Customer</p>
                                </div>
                            </div>
                            <div class="item">
                               <div class="info">
                                    <p>Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Nulla porttitor accumsan tincidunt. Pellentesque in ipsum id orci porta dapibus. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    <p class="testimonial-nane">Karla Anderson - Happy Customer</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="info">
                                    <p>Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Ut a nisl id ante tempus hendrerit. Vivamus aliquet elit ac nisl. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Maecenas malesuada.</p>
                                    <p class="testimonial-nane">Karla Anderson - Happy Customer</p>
                                </div>
                            </div>

                            <div class="item">
                                <div class="info">
                                    <p>Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Ut a nisl id ante tempus hendrerit. Vivamus aliquet elit ac nisl. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Maecenas malesuada.</p>
                                    <p class="testimonial-nane">Karla Anderson - Happy Customer</p>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>


            </div><!-- Block Testimonials -->
          
    <!-- block  showcase-->
            <div class="block-showcase block-showcase-opt1 block-brand-tabs">
                <div class="container">

                    <div class="block-title">
                        <span class="title">brand showcase</span>
                    </div>

                    <div class="block-content" >
                        
                        <ul class="nav-brand owl-carousel"  
                            data-nav="true" 
                            data-loop="true"
                            data-dots="false" 
                            data-margin="1" 
                            data-responsive='{
                            "0":{"items":3},
                            "380":{"items":4},
                            "480":{"items":5},
                            "640":{"items":7},
                            "992":{"items":8}
                        }'>
                            <li  data-tab="brand1-1">
                                <img src="<?= $path?>/images/b01.jpg" alt="img">
                            </li>
                            <li   data-tab="brand1-2">
                                <img src="<?= $path?>/images/b02.jpg" alt="img">
                            </li>
                            <li   data-tab="brand1-3">
                                <img src="<?= $path?>/images/b03.jpg" alt="img">
                            </li>
                            <li   data-tab="brand1-4">
                                <img src="<?= $path?>/images/b04.jpg" alt="img">
                            </li>
                            <li  data-tab="brand1-5">
                                <img src="<?= $path?>/images/b05.jpg" alt="img">
                            </li>
                             <li  data-tab="brand1-1">
                                <img src="<?= $path?>/images/b01.jpg" alt="img">
                            </li>
                            <li   data-tab="brand1-2">
                                <img src="<?= $path?>/images/b02.jpg" alt="img">
                            </li>
                            <li   data-tab="brand1-3">
                                <img src="<?= $path?>/images/b03.jpg" alt="img">
                            </li>
                            <li   data-tab="brand1-4">
                                <img src="<?= $path?>/images/b04.jpg" alt="img">
                            </li>
                            <li  data-tab="brand1-5">
                                <img src="<?= $path?>/images/b05.jpg" alt="img">
                            </li>
                             <li  data-tab="brand1-1">
                                <img src="<?= $path?>/images/b01.jpg" alt="img">
                            </li>
                            <li   data-tab="brand1-2">
                                <img src="<?= $path?>/images/b02.jpg" alt="img">
                            </li>
                            <li   data-tab="brand1-3">
                                <img src="<?= $path?>/images/b03.jpg" alt="img">
                            </li>
                            <li   data-tab="brand1-4">
                                <img src="<?= $path?>/images/b04.jpg" alt="img">
                            </li>
                            <li  data-tab="brand1-5">
                                <img src="<?= $path?>/images/b05.jpg" alt="img">
                            </li>
                        </ul>
                                           </div>

                </div>
            </div><!-- block  showcase-->


            </main><!-- end MAIN -->
            
           
        
            <a href="#" class="back-to-top">
                <i aria-hidden="true" class="fa fa-angle-up"></i>
            </a>
            
        </div>

<?php
// $x = Url::toRoute(['/main/default/auto-refresh-cart']);
// $js = <<<JS
//  $(function() {
//       $("#addtocart").click(function() {
//         console.log('hi');
//         $("#cart_item").load("$x");
//       })
//     });
// JS;
// echo $this->registerJs($js, yii\web\View::POS_READY, 'iCheck-login')
?>




<!-- $(document).ready(function(){
setInterval(function(){
$("#cart_item").load("$x")
},2000);
}); -->

<?php
use yii\helpers\Url;
$path = Yii::$app->request->baseUrl;
?>
<div class="columns container">
 <!-- Block  Breadcrumb-->

         <ol class="breadcrumb no-hide">
             <li><a href="#">Home    </a></li>
             <li class="active">Your shopping cart</li>
         </ol><!-- Block  Breadcrumb-->

         <div class="page-content page-order">
             <div class="heading-counter warning">Your shopping cart contains:
                 <span><?= $this->params['count'];?> Product</span>
             </div>
             <?php if(!empty($this->params['products'])):?>
             <div class="order-detail-content">
                 <div class="table-responsive">
                     <table class="table table-bordered  cart_summary">
                         <thead>
                             <tr>
                                 <th class="cart_product">Product</th>
                                 <th>Description</th>
                                 <th>Unit price</th>
                                 <th>Qty</th>
                                 <th>Total</th>
                                 <th class="action"><i class="fa fa-trash-o"></i></th>
                             </tr>
                         </thead>
                         <tbody>
                           <?php foreach($this->params['products'] as $product) :?>

                             <tr>
                                 <td class="cart_product">
                                     <a href="product.php" target="_blank"><img alt="Product" src="<?= $path?>/images/p02.jpg"></a>
                                 </td>
                                 <td class="cart_description">
                                     <p class="product-name"><a href="product.php" target="_blank"><?= $product->name;?></a></p>
                                     <small class="cart_ref">Part No. #<?= $product->part_no?></small><br>
                                 </td>
                                 
                                 <td class="price"><span> <?= $this->params[$product->id]['single_price']?><br><span style="text-decoration: line-through;color: red;font-weight: bold">(Rs. <?= $product['price']?>)</span></span></td>

                                 <td class="qty">
                                    <input type="hidden" id="hid1" value="<?php echo Url::toRoute(['site/auto-refresh-cart'])?>" name="">
                                     <input type="text" minlength="1" maxlength="99" name="qty0<?= $product->prdt_id;?>" id="qty0<?= $product->prdt_id;?>" value="<?= $this->params[$product->id]['item_count'][0]?>"  class="form-control input-sm" readonly>
                                     <span data-field="qty0<?= $product->prdt_id;?>" data-type="minus" class="btn-number" onclick='
                     									$.post("<?=  Url::toRoute(['site/delete-cart']);?>",{
                     										quantity : parseFloat($("#qty0<?= $product->id;?>").val()) - parseFloat(1),
                                       id : "<?= $product->prdt_id;?>",
                     									}).done(function(data,status){
                                                           // alert(data);
										var data = JSON.parse(data);
                     										$("#price<?= $product->prdt_id;?>").html(parseFloat(data.price).toFixed(2));
                                        $("#count_total").html(data.total_count);
                                        $("#total_tax").html("+"+data.tax_amount);
                                        $("#total_inc_tax").html(data.final_price_tax_inc);
                                        $("#total_rs").html(parseFloat(data.total_price).toFixed(2));
                                        $("#cart_number").html(data.total_count);
                                        $("#cart_number2").html(data.total_count);
                                        $("#total_cost").html(data.total_price);
                                        $("#total_cost1").html(data.total_price);
                                        $("#cart_item").load($("#hid1").val());
                                        $("#cart_item1").load($("#hid1").val());
                     									});
                     								'><i class="fa fa-caret-up"></i></span>
                                     <span  data-field="qty0<?= $product->prdt_id;?>" data-type="plus" class="btn-number" onclick='
                     									$.post("<?=  Url::toRoute(['site/update-cart']);?>",{
                     										quantity : parseFloat($("#qty0<?= $product->prdt_id;?>").val()) + parseFloat(1),
                                                          id : "<?= $product->prdt_id;?>",
                     									}).done(function(data,status){
                                                            //alert(data);
                                        var data = JSON.parse(data);
                                        $("#price<?= $product->prdt_id;?>").html(parseFloat(data.price).toFixed(2));
                                        $("#count_total").html(data.total_count);
                                        $("#total_tax").html("+"+data.tax_amount);
                                        $("#total_inc_tax").html(data.final_price_tax_inc);
                                        $("#total_rs").html(parseFloat(data.total_price).toFixed(2));
                                        $("#cart_number").html(data.total_count);
                                        $("#cart_number2").html(data.total_count);
                                        $("#total_cost").html(data.total_price);
                                        $("#total_cost1").html(data.total_price);
                                        $("#cart_item").load($("#hid1").val());
                                        $("#cart_item1").load($("#hid1").val());
                     									});
                     								'><i class="fa fa-caret-down"></i></span>
                                 </td>

                                 <td class="price">
                                     <span id="price<?= $product->id;?>"> <?php echo $this->params[$product->prdt_id]['item_count'][1]?></span>
                                 </td>
                                 <td class="action">
                                     <a href="<?=  Url::toRoute(['site/delete-item','product_id'=>$product->prdt_id]);?>">Delete item</a>
                                 </td>
                             </tr>
                            <?php endforeach;?>
                         </tbody>
                         <tfoot>
                             <tr>
                                 <td colspan="3"><strong>Total</strong></td>
                                 <td colspan="1" ><strong id="count_total"><?php echo $this->params['count']?></stong></td>
                                 <td colspan="2">Rs.<strong id="total_rs">  <?php echo $this->params['total']?></strong></td>
                             </tr>
                             <tr style="background-color: #fff;">
                                 <td colspan="3"><strong>Estimated Tax</strong></td>
                                 <td colspan="3"><strong id="total_tax">  +<?= $this->params['tax']?></strong></td>
                             </tr>
                             <tr>
                                 <td colspan="3"><strong>Final Amount</strong></td>
                                 <td colspan="3"><strong id="total_inc_tax"><?= $this->params['final_amount_inc_tax']?></strong></td>
                             </tr>
                         </tfoot>

                     </table>
                 </div>
                 <div class="cart_navigation">
                     <a href="catgrid.php" class="prev-btn">Continue shopping</a>
                     <a href="<?= Url::to(['checkout/address']); ?>" class="next-btn">Next Step</a>
                 </div>
             <?php endif;?>
             </div>
         </div>
         <br>
     </div>

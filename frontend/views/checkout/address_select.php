<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use kartik\dialog\Dialog;

$path = Yii::$app->request->baseUrl;
echo Dialog::widget();
// print_r($this->params['coupon_amount']);
?>
<h3>Select Address</h3>
<div class="box-border">
	<button type="button" title="Add New Address" id="modelButton" value="<?php echo \yii\helpers\Url::to(['checkout/create'])?>"><i class="fa fa-plus" aria-hidden="true">
	</i></button>
<?php
            
    Modal::begin([
            'header' => '<h4>Shipping Address</h4>',
            'id'     => 'model',
            'size'   => 'modal-lg',
    ]);
    
    echo "<div id='modelContent'></div>";
    
    Modal::end();
            
?>
<input type="hidden" id="area_del" value="<?= Url::toRoute(['checkout/delete'])?>">
<input type="hidden" id="make_default" value="<?= Url::toRoute(['checkout/make-default'])?>">
 <?php $form = ActiveForm::begin(['id' => 'form-Shipping','action'=>Url::toRoute(['checkout/final-checkout'])]); ?>
	<div class="row" style="padding: 10px;cursor: pointer;">
		<?php foreach($address as $usr_addr):?>
		<div class="col-sm-4" id="address_<?= $usr_addr['add_id'];?>" >
			<div class="card-deck">
				<div class="card attribute">
					<div class="card-block" style="padding: 20px;">
						<div onclick="func(<?= $usr_addr['add_id'];?>)">

						<div class="card-title">Shipping/Billing Address</div>

						<div class="card-description">
							<div class="card-heading">Address Desc</div>
							<p class="card-text"><?= $usr_addr['name']?></p>
							<p class="card-text"><?= $usr_addr['mobile']?></p>
							<p class="card-text"><?= $usr_addr['address1']?>,<?= $usr_addr['address2']?>,</p>
							
							<p class="card-text">(<?= $usr_addr['landmark']?>),</p>
							<p class="card-text"><?= $usr_addr['city']?>,<?= $usr_addr['state']?>,<?= $usr_addr['country']?></p>
							<p class="card-text">Pin:<?= $usr_addr['pin']?></p>
						</div>
					</div>
					<br>
				
						
						<a type="button" title="Add New Address" class="modalButtonEdit" value="<?php echo \yii\helpers\Url::to(['checkout/create','id'=>$usr_addr['add_id']])?>"><i class="fa fa-pencil" aria-hidden="true" title="Edit Address"></i></a>
						

						<a id="addr_del" onclick="
						    krajeeDialog.confirm('Are you sure you want to Delete?', function (result) {
						        if (result) {
						        	var area_del = $('#area_del').val();
						            //alert('Great! You accepted!');
						            $.post(area_del,{
						            	'id':<?= $usr_addr['add_id']?>,

						            },function(data,status){
						            	if(data == 1){
						            	 location.reload();
						            	}else{
						            	var n = Noty('id');
                                        $.noty.setText(n.options.id,'<i class=\'fa fa-check\' aria-hidden=\'true\'></i>&nbsp;&nbsp;'+'Default address can not be deleted!');
                                        $.noty.setType(n.options.id, 'error');
						            	}
						            });
						        }
						    });
						"><i class="fa fa-trash" aria-hidden="true" title="Delete Address" style="padding-left:0.4em"></i></a>

					<?php if($usr_addr['is_default'] == 0):?>

						<a onclick="
						        	var area_def = $('#make_default').val();
						            $.post(area_def,{
						            	'id':<?= $usr_addr['add_id']?>,
						            },function(data,status){
                                        location.reload();
						            });
						"><i class="fa fa-check-square" aria-hidden="true" title="Make It Default Address" style="padding-left:0.4em"></i></a>

					<?php endif;?>
						<?php if($usr_addr['is_default']==1):?>
						<button class="pull-right chk" style="background-color: green;font-size: 1.3em;" disabled="true"><i class="fa fa-check-circle" aria-hidden="true"></i></button>
					<?php endif;?>
					<button class="pull-right chk" style="background-color: green;font-size: 1.3em;display: none;" id="but_<?= $usr_addr['add_id']?>" disabled="true"><i class="fa fa-check-circle" aria-hidden="true"></i></button>
					<input type="radio" name="addr" checked="true" style="display: none;" id="addr_<?= $usr_addr['add_id']?>" value = "<?= $usr_addr['add_id']?>">
					</div>
				</div>
			</div>
		</div>
	<?php endforeach;?>
	</div>
</div>                       
<h3 class="checkout-sep">Shipping Method</h3>
<div class="box-border">
	<ul class="shipping_method">
		<li>
			<label for="radio_button_3"><input checked="" name="shipping_method" id="radio_button_3" type="radio" value="0">Free ₹0</label>
		</li>
		<li>
			<label for="radio_button_4"><input name="shipping_method" id="radio_button_4" type="radio" value="1"> Standard Shipping ₹500</label>
		</li>
	</ul>
</div>
<h3 class="checkout-sep">Payment Information</h3>
<div class="box-border">
	<ul>
		<li>
			<label for="radio_button_5"><input checked="" name="payment_type" id="radio_button_5" type="radio" value="0"> Paytm</label>
		</li>

		<li>

			<label for="radio_button_6"><input name="payment_type" id="radio_button_6" type="radio" value="1">Pay-U Money</label>
		</li>

	</ul>
</div>
<h3 class="checkout-sep">Order Review</h3>
<div class="box-border">
	<div class="table-responsive">
		<table class="table table-bordered  cart_summary">
			<thead>
				<tr>
					<th class="cart_product">Product</th>
					<th>Description</th>
					<th>Avail.</th>
					<th>Unit price</th>
					<th>Qty</th>
					<th>Total</th>

				</tr>
			</thead>
			<tbody>
				 <?php foreach($this->params['products'] as $product) :?>
				<tr>
					<td class="cart_product">
						<a href="#"><img src="<?= $path?>/images/media/detail/product-100x122.jpg" alt="Product"></a>
					</td>
					<td class="cart_description">
						<p class="product-name"><a href="#"><?= $product->name;?></a></p>
						<small class="cart_ref">Part No. # <?= $product->part_no;?></small><br>
						
					</td>
					<td class="cart_avail"><span class="label label-success">In stock</span></td>
					<td class="price"><span> <?= $this->params[$product->id]['single_price']?><br><span style="text-decoration: line-through;color: red;font-weight: bold">(Rs. <?= $product['price']?>)</span></span></td>
					<td class="qty">

						<input name="qty1" id="qty1" value="<?= $this->params[$product->id]['item_count'][0]?>" class="form-control input-sm" type="text" disabled="true">
					</td>
					<td class="price">
                     <span id="price<?= $product->id;?>"> <?php echo $this->params[$product->prdt_id]['item_count'][1]?></span>
                 	</td>

				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
                             <tr>
                                 <td colspan="4"><strong>Total</strong></td>
                                 <td colspan="1" ><strong id="count_total"><?php echo $this->params['count']?></stong></td>
                                 <td colspan="2">Rs.<strong id="total_rs">  <?php echo $this->params['total']?></strong></td>
                             </tr>
                             <tr style="background-color: #fff;">
                                 <td colspan="4"><strong>Estimated Tax</strong></td>
                                 <td colspan="3"><strong id="total_tax">  <?= $this->params['tax']?></strong></td>
                             </tr>
                             <tr id="shipping_cost" style="background-color: #fff">
                                 <td colspan="4"><strong>Shipping Cost</strong></td>
                                 <td colspan="3"><strong id="total_shipping_cost">  +0</strong></td>
                             </tr>
                          <?php $x = (Yii::$app->session->get('coupon_amount') == '')?'display:none':''; ?>
                             <tr id="coupon_cost" style="background-color: #fff;<?= $x;?>">
                                 <td colspan="4"><strong>Coupon</strong></td>
                                 <td colspan="3">- <strong id="total_coupon_amount">  <?= Yii::$app->session->get('coupon_amount');?></strong>&nbsp;&nbsp;&nbsp;<?= Html::a('<i class="fa fa-times" aria-hidden="true"></i>', ['checkout/remove-coupon'], ['class' => 'teaser','style'=>'padding: 2px;padding-right: 5px;padding-left: 5px;background-color:red;color:#fff;','title'=>'Remove Coupon']) ?></td>
                             </tr>
                       
                             <tr>
                                 <td colspan="4"><strong>Final Amount</strong></td>
                                 <td colspan="3"><strong id="total_inc_evrthng">Rs <?= (Yii::$app->session->get('coupon_amount') == '')?$this->params['final_amount_inc_tax']:($this->params['final_amount_inc_tax']-Yii::$app->session->get('coupon_amount'))?></strong></td>
                             </tr>
                         </tfoot>  
		</table>

		<input type="hidden" name="total_inc_evrthng" id="inp_total_inc_evrthng" value="<?= $this->params['final_amount_inc_tax']?>">
	</div>

</div>
<div class="box-border">
	<div class="row">
	 <div class="col-md-3">
            <div class="input-append">
                <input type="text" id="coupon_code" placeholder="Have any coupon?Apply it !" class="form-control tt-input" name="coupon">
            </div>
     </div>
     <div class="col-md-2">
     	<?php $x = (round($this->params['total']+$this->params['tax']));?>
     	 <?php echo Html::button('Apply', ['class' => 'button','style'=>'margin-left: -20px;padding: 7px;min-width: 50px;','onclick' =>'
                                                                $.post("'.Url::toRoute(['checkout/apply-coupon']).'",{
                                                                    code : $("#coupon_code").val(),
                                                                    price: '.round(($this->params['total']+$this->params['tax'])).',
                                                                    count:'.$this->params['count'].'
                                                                }).done(function(data,status){
                                                                	 var data = JSON.parse(data);
                                                                  	if(data.data == ""){
                                                                  		var n = Noty("id");
			                                                        $.noty.setText(n.options.id,"<i class=\"fa fa-times\" aria-hidden=\"true\"></i>&nbsp;&nbsp;"+data.response);
			                                                        $.noty.setType(n.options.id, "error");
			                                                    	}else{

			                                                    		  var data1 = JSON.parse(data.data);
			                                                    		  $("#coupon_cost").show();
			                                                    		  $("#total_coupon_amount").text(data1);
			                                                    		  $("#total_inc_evrthng").text('.$x.'-parseInt(data1));
			                                                    		  var n = Noty("id");
			                                                        $.noty.setText(n.options.id,"<i class=\"fa fa-check\" aria-hidden=\"true\"></i>&nbsp;&nbsp;"+data.response);
			                                                        $.noty.setType(n.options.id, "success");
			                                                    		  
			                                                    	}
                                                                });
                                                            '  ]);?>
     </div>
     <div class="col-md-4 pull-right">
     	<button type="submit" name="billing-button" class="button pull-right">Place Order</button>
     </div>
</div>
</div>
<?php ActiveForm::end(); ?>        
<input type="hidden" id="shipping_cost_calc" value="<?= Url::toRoute(['checkout/shipping-cost-calc']);?>">
<?php
$js = <<<JS
    $(document).ready(function() {
    	var shipping_url = $("#shipping_cost_calc").val();
    	$('input[type=radio][name=shipping_method]').change(function() {
	    	$.post(shipping_url,{
	    		shipping_id: $(this).val(),
	    	},function(data){
	    		var data1 = JSON.parse(data);
	    		var shipping_cost = data1[0].shipping_cost;
	    		var total_cost = data1[0].total_cost;
	    		$("#total_shipping_cost").html('+'+shipping_cost);
	    		$("#total_inc_evrthng").html('Rs '+total_cost);
	    		$("#inp_total_inc_evrthng").val(total_cost);
	    		
	    	});
    	});
    });
JS;
echo $this->registerJs($js);
?>
<?php

?>
<?php if(!empty($appSug)):?>
	<hr>
<h5>Suggestion :</h5>
	<div id="addedProducts" class="table-responsive">
							<table id="example2" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>ID</th>
										<th>Product Name</th>
										<th>Product Brand</th>
										<th>Qualtity</th>
										<th>Availablity</th>
										<th>Shipping Time</th>
										<th>Shipping Charges</th>
										<th>Tax</th>
										<th>Warranty</th>
										<th>Vendor Price Details</th>
										<th>Total Payment</th>
									</tr>
								</thead>
								<tbody>
									<?php $x = 1;?>
									<?php foreach($appSug as $key):?>
									<tr>
										<td><?= $x;?></td>
										<td><?= $key['part_name']?></td>
										<td><?= $key['brand']?></td>
										<td><?php
											if($key['quality']==1){
												echo "Genuine";
											}else if($key['quality']==2){
												echo "Performanced";
											}else if($key['quality']==3){
												echo "Imported";
											}else if($key['quality']==4){
												echo "Refurbished";
											}else if($key['quality']==5){
												echo "After Market";
											}else{
												echo "O.E. Replacement";
											}	
										?></td>
										<td><?= ($key['availability']==1)?"Yes":"No"?></td>
										<td><?= $key['shipping_time']." days"?></td>
										<td><?= $key['shipping_charges']?></td>
										<td><?= $key['tax']."%"?></td>
										<td><?= ($key['warranty']==1)?"Yes(Fitment)":"No"?></td>
										<td><?= $key['vendor_price']?></td>
										<td><?= $key['vendor_price']+(($key['vendor_price']*$key['tax'])/100)+$key['shipping_charges'];?></td>
									</tr>
									<?php $x++;?>
								<?php endforeach;?>
								</tbody>
							</table>
						</div>
<?php endif;?>
<?php if(empty($appSug)):?>
	<hr>
<h5>Suggestion :</h5>
	<p><b>No Suggestion Found!Please Add one.</b></p>
	<hr>
<?php endif;?>
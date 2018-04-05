<?php
use common\ models\AppProductSuggestion;
?>
<?php if(!empty($logs)):?>
<?php 
$x=1;
foreach($logs as $log): ?>
<?php if(!is_null($log['suggestion_id'])):?>
<?php
$data = AppProductSuggestion::find()
							->where(['enquiry_product_id'=>$enquiry_product_id])
							->one();
?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><?= $x;?>. Part Suggested By: <?= $log['userName']['first_name']." ".$log['userName']['last_name'];?>, At <?= Yii::$app->formatter->asDatetime($log['created_at'], 'd LLL yyyy, H:mm:ss')?></h3>
  </div>
  <div class="panel-body">
    <table class="table row">
    <thead>
      <tr>
        <th>Part Name</th>
        <th>Brand</th>
        <th>Quality</th>
        <th>Availability</th>
        <th>Shipping Time(in Days)</th>
        <th>Shipping Charges(Rs.)</th>
        <th>Tax(%)</th>
        <th>Warranty</th>
        <th>Vendor Price</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?= $data['part_name']?></td>
        <td><?= $data['brand']?></td>
        <td><?php
        	if($data['quality']==1){
        		echo "Genuine";
        	}else if($data['quality']==2){
        		echo "Performanced";
        	}else if($data['quality']==3){
        		echo "Imported";
        	}else if($data['quality']==4){
        		echo "Refurbished";
        	}else if($data['quality']==5){
        		echo "After Market";
        	}else{
        		echo "O.E. Replacement";
        	}
        ?></td>
        <td><?= ($data['availability']==1)?"Yes":"No"?></td>
        <td><?= $data['shipping_time']?></td>
        <td><?= $data['shipping_charges']?></td>
        <td><?= $data['tax']?></td>
        <td><?= ($data['warranty']==1)?"Yes(Fitment)":"No"?></td>
        <td><?= $data['vendor_price']?></td>
      </tr>
      
     
    </tbody>
  </table>
  </div>
</div>
<?php endif;?>
<?php if(!is_null($log['agent_remarks'])):?>
	<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title"><?= $x;?>. Remarked By: <?= $log['userName']['first_name']." ".$log['userName']['last_name'];?>, At <?= Yii::$app->formatter->asDatetime($log['created_at'], 'd LLL yyyy, H:mm:ss')?></h3>
  </div>
  <div class="panel-body">
   	<p><?= $log['agent_remarks']?></p>
  </div>
</div>
<?php endif;?>
<?php
$x++;
endforeach;?>
<?php endif;?>
<?php if(empty($logs)):?>
	<p>Sorry No History Found!</p>
<?php endif;?>
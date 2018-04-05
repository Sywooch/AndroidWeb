<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<style>
	#model{
		margin-left: -17px;
	}
</style>
<div class="modal-body">
						<div id="desc">
							<table class="table table-bordered table-responsive">
								<tbody>
									<tr>
										<th>Category Name:</th>
										<td><?= $model['catName']['name']?></td>
									</tr>
									<tr>
										<th>Sub-Category Name:</th>
										<td><?= $model['subCatName']['name']?></td>
									</tr>
									<tr>
										<th>Part Name:</th>
										<td><?= $model['name']?></td>
									</tr>
									<tr>
										<th>Requirement Details:</th>
										<td><?= $requirement_details?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div id="imgs" class="row">

							<?php foreach($image as $key):?>
							<div class="col-md-3 col-xs-3 no-padding" >
								<a href="dist/images/test1.jpg">
								
									<?= Html::img('http://'.$key['image'], ['alt' => $key['alt_text'],'style'=>'border: 1px #fff solid;height: 93.58px;width: 222.5px;']) ?>
								</a>
							</div>
						<?php endforeach;?>

						</div>
						<br>
						<input type="hidden" type="text" id="show_sugg" value="<?= Url::toRoute(['car-enquiry/show-suggestion?enquiry_product_id='.$enquiry_product_id]);?>">
						<div id="table_sugg">
						<?= $this->renderAjax('_table',['appSug'=>$appSug])?>
						</div>
						<br>
					<?php $form = ActiveForm::begin(['id' => 'form-signsup',

                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    //'id' => 'ajax'
                    ]); ?>
					<?= $form->field($model1, 'agent_remark')->textarea(['rows' => '6','style'=>'resize:none']); ?>
					<?= Html::submitButton('Submit', ['class' => 'btn btn-success','name'=>'sub']) ?>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary modelButton" value="<?php echo \yii\helpers\Url::to(['car-enquiry/suggested-product/'.$enquiry_product_id])?>">Add Suggested Product</button>
						<button class="btn btn-info modelButton3" value="<?php echo \yii\helpers\Url::to(['car-enquiry/agent-logs/'.$enquiry_product_id])?>">Agent History</button>
					</div>
					<?php ActiveForm::end(); ?> 
<?php
            
    Modal::begin([
        'header' => '<h4 id="modal-title1">Add Part Detail</h4>',
    	'headerOptions' => ['id' => 'modalHeader'],
            'id'     => 'model',
            'size'   => 'modal-lg',
            'closeButton' => [
	        'id'=>'close-button1',
	        ],
	        'clientOptions' => [
	        'backdrop' => false, 'keyboard' => true
	        ],
            'footer' => ' <button type="button" id="close_part" class="btn btn-secondary">Close</button>'
    ]);
    
    echo "<div id='modelContent1'><div style='text-align:center'></div></div>";
    
    Modal::end();
?>
            

<?php
$script = <<< JS
    $(document).ready(function(){
	//1.hide the cross button
	$('#close-button1').hide();

	//modal show on click
	$('.modelButton').click(function(){
		$('#modal-title1').html('Add Part Suggestion');
        $('.modal').modal('show')
            .find('#modelContent1')
            .load($(this).attr('value'));
    });

    $('.modelButton3').click(function(){
    	$('#modal-title1').html('Previous Followups');
        $('#model').modal('show')
            .find('#modelContent1')
            .load($(this).attr('value'));
    });

    //back screen black problem solve
    $('.modal').on('hidden.bs.modal', function (e) {
	    if($('.modal').hasClass('in')) {
	    $('body').addClass('modal-open');
	    $('.modal-backdrop').remove();

	    $("#table_sugg").load($('#show_sugg').val());

	    }
	});

	//after closing by close button
	$('#close_part').on('click',function(){
		$('#model').modal('hide');
	});

});
JS;
$this->registerJs($script);
?>
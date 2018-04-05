<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
?>
<div class="box">
        <div class="box-header with-border">
<div class="box-body">

	 <?php $form = ActiveForm::begin(['id'=>'pending_followup']); ?>
	 <?= $form->field($model,'user_id')->textInput(['type'=>'hidden','value'=>$model1['userName']['id']])->label(false)?>
		<div class="row margin-top10">
			<div class="col-md-3">
				<?= $form->field($model, 'user_name')->textInput(['readonly'=>true,'value'=>$model1['userName']['garage_owner_name']])->label('Name') ?>
			</div>
			<div class="col-md-3">
				<?= $form->field($model, 'rep_email')->textInput(['readonly'=>true,'value'=>$model1['userName']['email']])->label('Email') ?>
			</div>
			<div class="col-md-3">
				<?= $form->field($model, 'mobile')->textInput(['readonly'=>true,'value'=>$model1['userName']['mobile']])->label('Mobile') ?>
			</div>
			<div class="col-md-3">
				<?= $form->field($model, 'car_chassis_number')->textInput(['readonly'=>true,])->label('Car Chassis Number') ?>
			</div>
		</div>
		<div class="row margin-top10">
			<div class="col-md-3">
				<?= $form->field($model, 'brand')->textInput(['readonly'=>true,])->label('Brand') ?>
			</div>
			<div class="col-md-3">
				<?= $form->field($model, 'model')->textInput(['readonly'=>true,])->label('Model') ?>
			</div>
			<div class="col-md-3">
				<?= $form->field($model, 'variant')->textInput(['readonly'=>true,])->label('Variant') ?>
			</div>
			<div class="col-md-3">
				<?= $form->field($model, 'year')->textInput(['readonly'=>true,])->label('Year') ?>
			</div>
		</div>
		<div class="row margin-top10">
			<div class="col-md-3">
				<?= $form->field($model, 'enq_source')->textInput(['readonly'=>true,'value'=>'Autokartz Mobile App'])->label('Enquiry Source') ?>
			</div>
			<div class="col-md-3">

				<?= $form->field($model, 'created')->textInput(['readonly'=>true,'value'=>Yii::$app->formatter->asDatetime($model->created_at, 'd LLL yyyy, H:mm:ss')])->label('Created On') ?>
			</div>
			<?php if($model->updated_by != ''):?>
			<div class="col-md-3">
				<?= $form->field($model, 'updated_by')->textInput(['readonly'=>true,'value'=>$userData['first_name'].' '.$userData['last_name']])->label('Last Updated By') ?>
			</div>
		<?php endif;?>
			<div class="col-md-3">
				<?= $form->field($model, 'status')->dropDownList(
			            ['4'=>'Complete Enquiry'],
			            ['options'=>["selected"=>"selected"],'prompt'=>'~~~~ Select action ~~~~','id'=>'complete_status']
			    ); ?>
			</div>
		</div>
		<div class="row margin-top10">
			<div class="col-md-12">
				<label>Client's Query</label>
				<div class="row">
					<?php
					$x = 1;
					 foreach($model2 as $key):?>
					<div class="col-md-2 col-xs-6">
						<button type="button" title="Part Details" class="btn btn-primary form-control modelButton1" value="<?php echo \yii\helpers\Url::to(['car-enquiry/part-details/'.$key['part_id'].'/'.$enq_id])?>">Part <?= $x?></button>
					</div>
					<?php
					$x++;
					 endforeach;?>
					
					
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-3 margin-top10">
				<button type="submit" class="btn btn-success" id="complete_enq" value="<?php echo \yii\helpers\Url::to(['car-enquiry/complete-enq-form?enq_id='.$enq_id])?>">SUBMIT</button>
			</div>
		</div>
	
	 <?php ActiveForm::end(); ?>
</div>
</div>
</div>
<?php
            
    Modal::begin([
            'header' => '<h4 id="modal-title">Part Detail</h4>',
            'id'     => 'model_pend_enq',
            'size'   => 'modal-lg',
            'footer' => ' <button type="button"  id="close_part1"  class="btn btn-danger">Close</button>'

    ]);
    
    echo "<div id='modelContent'></div>";
    
    Modal::end();
            
?>




<?php
$script = <<< JS
    $(document).ready(function(){
    	

    $('.modelButton1').click(function(){
    	$('#modal-title').html('Part Detail');
    	$('#model').modal('hide');
        $('.modal').modal('show')
            .find('#modelContent')
            .load($(this).attr('value'));
    });

    $('#complete_enq').click(function(e){
    	e.preventDefault();
    	if($('#complete_status').val() == 4){
    		$('#modal-title').html('Provide a specify reason to submit as a complete enquiry');
	        $('.modal').modal('show')
	            .find('#modelContent')
	            .load($(this).attr('value'));
    	}else{
    
    		 var n = Noty("id");
            $.noty.setText(n.options.id,"<i class=\"fa fa-times\" aria-hidden=\"true\"></i>&nbsp;&nbsp;"+"please select status at first!");
            $.noty.setType(n.options.id, "error");
    	}
    });

    $('.modal').on('hidden.bs.modal', function (e) {
	    if($('.modal').hasClass('in')) {
	    $('body').addClass('modal-open');
	    $('.modal-backdrop').remove();
	     }    
	});

	//after closing by close button
	$('#close_part1').on('click',function(){
		$('#model_pend_enq').modal('hide');
	});

	
});
JS;
$this->registerJs($script);
?>
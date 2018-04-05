<?php
	
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Url;
	use modules\users\widgets\passfield\Passfield;
	use modules\users\widgets\passfield\assets;
	use modules\users\models\User;
	
	$this->title = 'Shipping Address';
	$this->params['breadcrumbs'][] = $this->title;
	$path = Yii::$app->request->baseUrl;
	//print_r($address['name']);exit();
?>

<main class="site-main" >
	
	<div class="columns container">
		
		<div class="page-content page-order">
			
			<div class="order-detail-content">
				
				<div class="col-sm-8 box-border">
					
					
					<?php $form = ActiveForm::begin(['id' => 'form-Shipping']); ?>
					
					<?= $form->field($model, 'name')->textInput(['class' => 'form-control','placeholder'=>'Enter Full Name','value'=>is_null($address)?Yii::$app->user->identity['first_name']." ".Yii::$app->user->identity['last_name']:$address['name']])->label('Full Name'); ?>
					
					<?= $form->field($model, 'mobile')->textInput(['class' => 'form-control','placeholder'=>'Enter Mobile Number','value'=>is_null($address)?Yii::$app->user->identity['mobile']:$address['mobile']]) ?>
					
					<?= $form->field($model, 'address1')->textarea(['rows' => '2','placeholder'=>'Enter Address 1','style'=>'resize:none','value'=>is_null($address)?'':$address['address1']])->label('address 1(House No./Flat No.)') ?>
					
					<?= $form->field($model, 'address2')->textarea(['rows' => '2','placeholder'=>'Enter Address 2','style'=>'resize:none','value'=>is_null($address)?'':$address['address2']])->label('Address 2(Locality/Area Name)') ?>
					
					<?= $form->field($model, 'landmark')->textInput(['class' => 'form-control','placeholder'=>'Enter nearest Landmark','value'=>is_null($address)?'':$address['landmark']]) ?>
					
					<?= $form->field($model, 'pin')->textInput(['placeholder'=>'Enter pin code','id'=>'pincode','value'=>is_null($address)?'':$address['pin']]); ?>
					
					<?= $form->field($model, 'city')->dropDownList(['option'=>is_null($address)?['prompt'=>'Select...']:$address['city']],['id' => 'vCity']) ?>
					
					<?= $form->field($model, 'state')->dropDownList(['option'=>is_null($address)?['prompt'=>'Select...']:$address['state']],['id' => 'vState']) ?>
					
					<?= $form->field($model, 'country')->textInput(['class' => 'form-control','value'=>'India']); ?>
					
					<div class="form-group">
						<?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>Submit',['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
					</div>
					
					<?php ActiveForm::end(); ?>
					<input type="hidden" id="pinUrl" value="<?= Url::toRoute(['checkout/find-pin']) ?>">
				</div>
				
				
			</div>
			<br>
		</div>
		
		<h2> </h2>
		
	</main><!-- end MAIN -->
<?php
$js = <<<JS
    $(document).ready(function() {
    
        var pinURL = $('#pinUrl').val();
        
        $('#pincode').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
            $(this).attr('maxlength','6');
        });
        
        $('#pincode').on('keyup', function() {
        
            if($(this).val().length == 6){
                $.post(pinURL,{
                    pin : $(this).val(),
                }).done(function(data,status){
                    $.each(data, function (i, data) {
                        $('#vCity').append($('<option>', { 
                            value: data.district,
                            text : data.district,
                            selected: true 
                        }));
                    });
                    
                    $('#vState').append(new Option(data[0].pstate, data[0].pstate, false, true));
                });
            }
            else
            {
                $('#vCity').html('<option value="">Select...</option>');
                $('#vState').html('<option value="">Select...</option>');
            }
        });
        
    });
JS;
echo $this->registerJs($js);
?>
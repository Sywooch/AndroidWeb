<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Verification';
$this->params['breadcrumbs'][] = $this->title;
$path = Yii::$app->request->baseUrl;
?>
<div class="container be-detail-container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <br>
            <img src="<?= $path;?>/images/sms.png" class="img-responsive" style="width:200px; height:200px;margin:0 auto;"><br>

            <h1 class="text-center">Verify your mobile number and Email</h1><br>
            <p class="lead" style="align:center"></p><p> You need to verify your mobile no and email for better service.</p>  <p></p>
        <br>
            <?php $form = ActiveForm::begin(['id' => 'form-emailotp']); ?>
                <div class="row">
                <div class="form-group col-sm-8">
                	 <span style="color:red;"></span><input type="text" class="form-control" name="otp" value="<?= Yii::$app->user->identity->email;?>" required="" disabled="">
                </div>

								<?= Html::Button('Send OTP', ['class' => 'button', 'class'=>'btn btn-primary  pull-right col-sm-3', 'id'=>'otp_button', 'name' => 'otp','onclick'=>'
                    $.post("'.Url::toRoute(['site/get-timer']).'",{
                      id : $(this).attr("id"),
                      id_text : $("#test").attr("id"),
                    }).done(function(data1,status){
										$("#test").css("color", "green");
										 $("#test").html("Check your mail.You have recived an OTP and is valid for next 5 minuites.<b>Please wait : "+data1+" munites for the next otp request.</b>");
										 $("#otp_button").attr("disabled","disabled");
										 $("#test").css("display","inline-block");
                    });
            ']) ?><div>
              <span id="test" style="color: red;font-size: 1em;font-weight:bold;"></span>
            </div>
								<div class="form-group col-sm-5">
                	 <span style="color:red;"></span><?= $form->field($model, 'email_otp')->textInput(['class' => 'form-control']) ?>
                </div>
							<?= Html::submitButton('submit', ['class' => 'btn btn-primary  pull-right col-sm-3', 'name' => 'email-button']) ?>

                </div>
            <?php ActiveForm::end(); ?>
						<?php $form = ActiveForm::begin(['id' => 'form-mobileotp']); ?>
                <div class="row">
                <div class="form-group col-sm-8">
                	 <span style="color:red;"></span><input type="text" class="form-control" name="otp" value="+91 <?= Yii::$app->user->identity->mobile?>" required="" disabled="">
                </div>

								<?= Html::Button('Send OTP', ['class' => 'button', 'class'=>'btn btn-primary  pull-right col-sm-3', 'id'=>'otp_button1', 'name' => 'otp','onclick'=>'
                    $.post("'.Url::toRoute(['site/get-timer']).'",{
                      id : $(this).attr("id"),
                      id_text : $("#test1").attr("id"),
                    }).done(function(data2,status){
										$("#test1").css("color", "green");
										 $("#test1").html("Check your phone.You have recived an OTP and is valid for next 5 minuites.<b>Please wait : "+data2+" munites for the next otp request.</b>");
										 $("#otp_button1").attr("disabled","disabled");
										 $("#test1").css("display","inline-block");
                    });
            ']) ?>
            <div>
                <span id="test1" style="color: red;font-size: 1em;font-weight:bold;"></span>
            </div>
								<div class="form-group col-sm-5">
                	 <span style="color:red;"></span><?= $form->field($model, 'mobile_otp')->textInput(['class' => 'form-control']) ?>
                </div>
							<?= Html::submitButton('submit', ['class' => 'btn btn-primary  pull-right col-sm-3', 'name' => 'mobile-button']) ?>

                </div>
            <?php ActiveForm::end(); ?>
        <br><br>
        </div>
    </div>


</div>

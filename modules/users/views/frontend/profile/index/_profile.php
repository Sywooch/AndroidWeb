<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */
$path = Yii::$app->request->baseUrl;
?>
<div class="row">
    <div class="col-sm-2">
        <?php if ($model->avatar) : ?>
            <?= Html::img($path.'/'.$model->getAvatarPath(), [
                'class' => 'profile-user-img img-responsive img-circle',
                'style' => 'margin-bottom:10px; width:auto',
            ]); ?>
        <?php else : ?>
            <div class="col-sm-10 text-center">
                <i class="fa fa-user-circle fa-5x" style="color:#b9b9b9; margin-bottom:10px;"></i>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-sm-10">
        <span id='test' style='color: red;font-size: 1em;font-weight:bold;'></span>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                // 'id',
                'first_name',
                'last_name',
                'email:email',
                [
                     'attribute' => 'Mobile Number',
                    'format' => 'raw',
                    'value' => ($model->mobile_otp_status == 2) ? $model->mobile."&nbsp;&nbsp;<button type=button id='verify_btn' data-toggle='tooltip' data-placement='right' title='Unverified!Click to verify' style='background:red'><i class='fa fa-exclamation' aria-hidden='true'>Verify</i></button>&nbsp;&nbsp;<input id='otp_field' type='text' hidden>&nbsp;<button id='veri_btn' style='display:none;'>Verify</button>" : $model->mobile."&nbsp;&nbsp;<button type=button id='verify_btn' disabled='true' data-toggle='tooltip' data-placement='right' title='Verified' style='background:green' ><i class='fa fa-check' aria-hidden='true'></i></button>",
                ],
             
                'created_at:datetime',
                'updated_at:datetime',
                'last_visit:datetime',
            ],
        ]) ?>
    </div>
    <div class="col-sm-offset-2 col-sm-10">
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Update', ['update'], [
            'class' => 'btn btn-primary'
        ]) ?>
       
    </div>
</div>

<?php
$script = <<< JS
$(document).ready(function(){
    $('#verify_btn').click(function(){
        //alert('bye');
        $.post("profile/verify-mobile",{
                      id : $(this).attr("id"),
                    }).done(function(data,status){
                        $("#test").html("Check your Mobile,You have recived an Otp . <b>Please wait : "+data+" munites for the next otp request.</b>");
                        $("#otp_field").show();
                        $("#veri_btn").show();
                        $("#verify_btn").attr("disabled","disabled");
                    });
    });

    $('#veri_btn').click(function(){
        //alert('bye');
        $.post("profile/check-otp",{
                      otp : $("#otp_field").val(),
                    }).done(function(data,status){
                        location.reload();
                    });
    });
}); 
JS;
$this->registerJs($script);
?>
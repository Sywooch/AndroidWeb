<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\AppProductOrders;
/* @var $this yii\web\View */
/* @var $model common\models\AppCarEnquiry */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-car-enquiry-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'detail')->dropDownList(
            ['1'=>'with order #id','2'=>'others'],
            ['options'=>["selected"=>"selected"],'prompt'=>'~~~~ Select action ~~~~','id'=>'with_order_id']
        ); ?>


    <?php
        echo $form->field($model, 'order_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(AppProductOrders::find()->asArray()->all(), 'order_id', 'order_id'),
            'options' => ['placeholder' => 'Select a state ...','id'=>'order_id_find'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?= $form->field($model, 'add_reason')->dropDownList(
            ['1'=>'Customer not Interested','2'=>'Customer purchased','3'=>'Price High','4'=>'Others'],
            ['options'=>["selected"=>"selected"],'prompt'=>'~~~~ Select reason ~~~~','id'=>'add_reason_id']
        ); ?>

    <?= $form->field($model, 'reason')->textarea(['rows' => '6','style'=>'resize:none']); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$(document).ready(function(){
    $(".field-order_id_find").css("display","none");
    $(".field-add_reason_id").css("display","none");
    $(".field-appcarenquiry-reason").css("display","none");

    $("#with_order_id").change(function(){
         if($('select[id=with_order_id]').val() == 1){
            $(".field-order_id_find").css("display","block");
            $(".field-add_reason_id").css("display","none");
        }else if($('select[id=with_order_id]').val() == 2){
            $(".field-add_reason_id").css("display","block");
            $(".field-order_id_find").css("display","none");
        }
    });

    $("#add_reason_id").change(function(){
        if($('select[id=add_reason_id]').val() == 4){
            $(".field-appcarenquiry-reason").css("display","block");
        }else{
            $(".field-appcarenquiry-reason").css("display","none");
        }
    });
});
JS;
$this->registerJs($script);
?>
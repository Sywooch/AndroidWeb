<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\Pjax;
?>
<?php Pjax::begin(); ?>

<div class="customer-form" id="suggestion">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="fa fa-pencil-square" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Add Suggestion</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsAddress[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'full_name',
                    'address_line1',
                    'address_line2',
                    'city',
                    'state',
                    'postal_code',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
          
            <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Suggestion:</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelAddress->isNewRecord) {
                                echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                            }
                        ?>
                       
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelAddress, "[{$i}]part_name")->textInput(['onkeyup'=>"
                                    $(this).on('mouseleave',function(){
                                        $('.typeahead dropdown-menu').css('display','block');
                                    });
                                    $(this).typeahead({
                                                source:function(query,result)
                                                {
                                                    $.ajax({
                                                        url:'".Url::to(['car-enquiry/typeahead-partname'])."',
                                                        method:'POST',
                                                        data:{query:query},
                                                        dataType:'json',
                                                        success:function(data){
                                                            $('.typeahead dropdown-menu').css('display:block');
                                                            result($.map(data,function(item){
                                                                return item;
                                                            }));
                                                        }
                                                    });
                                                }
                                            });
                                ",'class'=>'form-control part_name_typeahead','autocomplete'=>"off"]);?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelAddress, "[{$i}]brand")->textInput(['maxlength' => true]) ?>
                            </div>
                        </div><!-- .row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelAddress, "[{$i}]quality")->dropDownList(['1' => 'Genuine', '2' => 'Performanced','3'=>'Imported','4'=>'Refurbished','5'=>'After Market','6'=>'O.E. Replacement']); ?>
                               
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelAddress, "[{$i}]availability")->dropDownList(['1' => 'Yes', '0' => 'No']); ?>
                            </div>
                        </div><!-- .row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelAddress, "[{$i}]shipping_time")->textInput(['maxlength' => true])->label('Shipping Time (Days)') ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelAddress, "[{$i}]shipping_charges")->textInput(['maxlength' => true])->label('Shipping Charge (Rs.)') ?>
                            </div>
                        </div><!-- .row -->
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelAddress, "[{$i}]tax")->textInput(['maxlength' => true])->label('Tax (%)') ?>
                            </div>
                            <div class="col-sm-4">
                                  <?= $form->field($modelAddress, "[{$i}]warranty")->dropDownList(['1' => 'In Warranty(Fitment)', '0' => 'Not in Warranty']); ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelAddress, "[{$i}]vendor_price")->textInput(['maxlength' => true])->label('Price (Rs.)') ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($modelAddress->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>

<?php
$script = <<< JS
$('form#dynamic-form').on('beforeSubmit',function(e){
    var form = $(this);
    $.post(
        form.attr("action"),
        form.serialize()
    ).done(function(result){
        $('#suggestion').html('<i class="fa fa-check"></i> Saved Successfully');
    }).fail(function(){
        console.log("server error");    
    });
    return false;
});

JS;
$this->registerJs($script);
?>
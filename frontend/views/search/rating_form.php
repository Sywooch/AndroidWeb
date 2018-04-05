 <?php
/* @var $this yii\web\View */
use kartik\rating\StarRating;
use yii\widgets\ActiveForm;
use yii\models\Review;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<?php Pjax::begin(['enablePushState' => false]); ?>
    <?php if (!Yii::$app->user->isGuest) :?>
    <?php $form = ActiveForm::begin(['id'=>'review-form','action'=>Url::toRoute(['search/save-review']),'options'=>['data-pjax'=>'#x1']])?>
                   
                        <?= $form->field($model, 'review')->textarea(['rows' => '5','class'=>'form-control animated'])->hint('Please enter your reviews') ?>
        				<?=
                            $form->field($model, 'rating')->widget(StarRating::classname(), [
                                    'pluginOptions' => [
                                     'size' => 'sm',
                                        'theme' => 'krajee-uni',
                                        'filledStar' => '&#x2605;',
                                        'emptyStar' => '&#x2606;'
                                        
                                    ]
                                ]);
        				?>
                        <?= $form->field($model, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>
                        <div class="text-right">
                            <div class="stars starrr" data-rating="0"></div>
                    
                            <?= Html::button('Cancel', ['class' => 'btn btn-danger btn-sm','id'=>'close-review-box']) ?>
                            <?= Html::submitButton('<i class="fa fa-pencil" aria-hidden="true"></i>Submit', ['class' => 'btn btn-success btn-sm','name'=>'review_submit']) ?>
                            <input type="hidden" name="prdt_id" value="<?= $prdt_id;?>">
                        </div>
    <?php ActiveForm::end();?>
<?php endif;?>
<?php if (Yii::$app->user->isGuest) :?>
    <h5>Please Login to submit a Review.Click <a href="<?= Url::toRoute(['/login']);?>" style="font-weight:bold">here</a> to login</h5>
    <?php endif;?>
<?php Pjax::end(); ?>
<div class ="col-md-6" id="x1"></div>
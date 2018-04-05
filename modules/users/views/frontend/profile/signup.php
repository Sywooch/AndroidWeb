<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use modules\users\widgets\passfield\Passfield;
use modules\users\widgets\passfield\assets;
use modules\users\models\User;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<main class="site-main">

                <div class="columns container">
                    <!-- Block  Breadcrumb-->



                    <div class="page-content page-order">

                        <div class="order-detail-content">
                            <div class="row">
                                <div class="col-sm-7 box-border">
                                <h3><ul>
                <li><label><input name="radio1" type="radio">&nbsp;<?= $this->title;?></input></label></li>
                                </ul></h3>
                                <p> New user? Please register below:</p>
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

           

            <?= $form->field($model, 'first_name')->textInput(['class' => 'form-control']) ?>

            <?= $form->field($model, 'last_name')->textInput(['class' => 'form-control']) ?>

            <?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>

            <?= $form->field($model, 'mobile')->textInput(['class' => 'form-control','type'=>'number','min'=>0]) ?>

            <?= Passfield::widget([
                'form' => $form,
                'model' => $model,
                'attribute' => 'password',
                'options' => [
                    'class' => 'form-control',
                ],
                'config' => [
                    'locale' => mb_substr(Yii::$app->language, 0, strrpos(Yii::$app->language, '-')),
                    'showToggle' => true,
                    'showGenerate' => true,
                    'showWarn' => true,
                    'showTip' => true,
                    'length' => [
                        'min' => User::LENGTH_STRING_PASSWORD_MIN,
                        'max' => User::LENGTH_STRING_PASSWORD_MAX,
                    ]
                ],
            ]); ?>

            <?= $form->field($model, 'confirm_password')->passwordInput(['class' => 'form-control']) ?>

            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span>Submit',['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

                                </div>

                                <div class="col-sm-5 box-border">
                                <h3><ul>
                                    <li><label><input name="radio1" type="radio"> Register Facilities</label></li>
                                </ul></h3>
                                <h4>Register and save time!</h4>
                                <p>Register with us for future convenience:</p>
                                <p><i class="fa fa-check-circle text-primary"></i> Fast and easy check out</p>
                                <p><i class="fa fa-check-circle text-primary"></i> Easy access to your order history and status</p>
                                </div>
                                <div class="cart_navigation">
                                    <a href="<?= Yii::$app->homeUrl;?>" class="prev-btn">Continue shopping</a>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>

                    <h2> </h2>

                </main><!-- end MAIN -->
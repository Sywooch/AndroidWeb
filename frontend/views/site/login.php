<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

		<main class="site-main">

				<div class="columns container">
					<!-- Block  Breadcrumb-->

					<ol class="breadcrumb no-hide">
						<li><a href="#">Home    </a></li>
						<li class="active">Your shopping cart</li>
					</ol><!-- Block  Breadcrumb-->

					<h2 class="page-heading">
						<span class="page-heading-title2">Shopping Cart Summary</span>
					</h2>

					<div class="page-content page-order">
						<ul class="step">
							<li><span>01. Summary</span></li>
							<li class="current-step"><span>02. Sign in</span></li>
							<li><span>03. Address</span></li>
							<li><span>04. Shipping</span></li>
							<li><span>05. Payment</span></li>
						</ul>
						<div class="heading-counter warning">Your shopping cart contains:
							<span>2 Login / Register / Guest Checkout</span>
						</div>
						<div class="order-detail-content">
							<div class="row">
								<div class="col-sm-7 box-border">
								<h3><ul>
                <li><label><input name="radio1" type="radio"> Login</label></li>
                                </ul></h3>
								<p>Already registered? Please log in below:</p>

								<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

		                <?= $form->field($model, 'email')->textInput(['autofocus' => true,'class'=>'form-control input']) ?>

		                <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control input']) ?>

		                <?= $form->field($model, 'rememberMe')->checkbox() ?>

		                <div style="color:#999;margin:1em 0">
		                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
		                </div>

		                <div class="form-group">
		                    <?= Html::submitButton('Login', ['class' => 'button', 'name' => 'login-button']) ?>
		                </div>

		            <?php ActiveForm::end();?>
								</div>

								<div class="col-sm-5 box-border">
								<h3><ul>
                                    <li><label><input name="radio1" type="radio"> Guest Checkout</label></li>
                                </ul></h3>
								<h4>Register and save time!</h4>
                                <p>Register with us for future convenience:</p>
                                <p><i class="fa fa-check-circle text-primary"></i> Fast and easy check out</p>
                                <p><i class="fa fa-check-circle text-primary"></i> Easy access to your order history and status</p>
                                <button class="button">Continue as Guest</button>
								</div>
								<div class="cart_navigation">
									<a href="orders.php" class="prev-btn">Continue shopping</a>
									<a href="billing.php" class="next-btn">Next Step</a>
								</div>
							</div>
						</div>
						<br>
					</div>

					<h2> </h2>

				</main><!-- end MAIN -->

			</div>

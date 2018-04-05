<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use \shifrin\noty\NotyWidget;
use modules\main\Module as MainModule;
use modules\users\Module as UserModule;
use kartik\widgets\Typeahead;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\CarInfoDropdown;
use kartik\widgets\DepDrop;
use \kartik\widgets\Growl;

AppAsset::register($this);
$path = Yii::$app->request->baseUrl;
//var_dump($this->params['prdt_name']);
foreach ($this->params['prdt_name'] as $key) {
	$array[] = $key['name'];
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Yii::$app->name . ' | ' . Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<style>
	.tt-menu{
		width: auto;
	}
	.header-opt-2 .header-nav {
   
    z-index: 99;
	}
</style>
<body class="cms-index-index index-opt-13">
	<?php $this->beginBody() ?>
	<div class="wrapper">
		<?php 
		echo NotyWidget::widget([    
		'options' => [ // you can add js options here, see noty plugin page for available options
		'dismissQueue' => true,
		'layout' => 'topRight',
		'theme' => 'metroui',
		'animation' => [
			'open' => 'animated bounceInRight',
			'close' => 'animated bounceOutRight',
		],
		'timeout' => 1500,
	],
	'enableSessionFlash' => false,
	'enableIcon' => true,
	'registerAnimateCss' => true,
	'registerButtonsCss' => true,
	'registerFontAwesomeCss' => true,
	]);?>
	<!-- alert banner top -->
<?php

?>
<div class="row">
    <div class="col-md-12">
        <?php foreach (Yii::$app->session->getAllFlashes() as $message):
			if(!empty($message['type']) && !empty($message['message'])){	
				echo Growl::widget([
				    'type' =>$message['type'],
				    'title' => 'AutoKartz!',
				    'icon' => 'glyphicon glyphicon-ok-sign',
				    'body' => Html::encode($message['message']),
				    'showSeparator' => true,
				    'delay' => 300,
				    'pluginOptions' => [
				    	'delay' => 3000, //This delay is how long the message shows for
				        'showProgressbar' => true,
				        'placement' => [
				            'from' => 'top',
				            'align' => 'right',
				        ]
				    ]
				]);
			}else{
					echo Growl::widget([
				    'type' =>Growl::TYPE_GROWL,
				    'title' => 'AutoKartz!',
				    'icon' => 'glyphicon glyphicon-ok-sign',
				    'body' => Html::encode($message['message']),
				    'showSeparator' => true,
				    'delay' => 900,
				    'pluginOptions' => [
				    	'delay' => 3000, //This delay is how long the message shows for
				        'showProgressbar' => true,
				        'placement' => [
				            'from' => 'top',
				            'align' => 'right',
				        ]
				    ]
				]);
			}
		endforeach; ?>
    </div>
</div>
	<div role="alert" id="offer_notification" class="qc-top-site qc-top-site4 alert  fade in" style="background-image: url(<?= $path;?>/images/topbar.jpg);display: none;">
		<div class="container">
			<button class="close" type="button"><span aria-hidden="true">×</span></button>
			<div class="description">
				<span class="title">Hot Offer Area</span>
				<span class="subtitle">Can be used to annouce offers</span>
				<span class="des">or other promotion/advertisements</span>

			</div>
		</div>
	</div><!-- alert banner top -->


	<!-- HEADER -->
	<header class="site-header header-opt-2 cate-show">
		<!-- header-top-left -->


		<!-- header-top -->

		<!-- heder links -->
		<div class="header-top">
			<div class="container">

				<!-- hotline -->
				<ul class=" nav-left" >
					<li ><span><i class="fa fa-phone" aria-hidden="true"></i>+91 97079-97079</span></li>
					<li ><span><i class="fa fa-envelope" aria-hidden="true"></i> Contact us today !</span></li>
				</ul><!-- hotline -->

				<!-- heder links -->
				<ul class="nav-right">
				<?php if (Yii::$app->user->isGuest):?>
					<li><a href="<?= Url::toRoute(['/users/profile/login'])?>"><span class="login_details">Hi Guest ! Please </span>Login</a></li>
				<?php endif;?>
				<?php if (!Yii::$app->user->isGuest):?>
					<li><a href="<?= Url::toRoute(['/users/profile/logout'])?>"><span class="login_details">Hello <?= Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name?>  </span> || Logout </a></li>
				<?php endif;?>
					<li class="dropdown setting">
						<a data-toggle="dropdown" role="button" href="#" class="dropdown-toggle "><span>My Account</span> <i aria-hidden="true" class="fa fa-angle-down"></i></a>
						<div class="dropdown-menu  ">

							<ul class="account">
								<li><a href="wishlist.php">Wishlist</a></li>
								<li><a href="profile.php">My Account</a></li>
								<li><a href="<?= Url::toRoute(['site/view-cart'])?>">Checkout</a></li>
								<li><a href="compare.php">Compare</a></li>
								<?php
								if (Yii::$app->user->isGuest) {
									echo "<li><a href=".Url::toRoute(['/users/profile/login']).">".UserModule::t('module', 'Login')."</a></li>";
									echo "<li><a href=".Url::toRoute(['/users/profile/signup']).">".UserModule::t('module', 'Sign Up')."</a></li>";
								} else {
									echo "<li><a href=".Url::toRoute(['/users/profile/index'])." id='logout_btn'><i class='glyphicon glyphicon-user'></i>&nbsp;&nbsp;Profile</a></li>";
									echo '<li>'
									. Html::beginForm(['/users/profile/logout'], 'post')
									. Html::submitButton(
										'<i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp;Logout(' . Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name . ')',
										['id'=>'logout_btn']
									)
									. Html::endForm()
									. '</li>';
								}
								?>
							</ul>
						</div>
					</li>
					<li><a href="<?= Url::toRoute(['/shop']);?>" >Shop All</a></li>
					<li><a href="support.autokartz.com" >Support</a></li>
					<li><a href="service.autokartz.com">Services </a></li>
				</ul>
			</div>
		</div>
		<!-- header-top-left -->

		<!-- header-content -->
		<div class="header-content">
			<div class="container">

				<div class="row">

					<div class="col-md-3 nav-left">
						<!-- logo -->
						<strong class="logo">
							<a href="<?= Yii::$app->homeUrl; ?>" title="<?= Yii::$app->name;?>"><img src="<?= $path;?>/images/logo.png" alt="logo"></a>

						</strong><!-- logo -->
					</div>



					<div class=" nav-right">

						<!-- link  wishlish-->
						<a href="compare.php" class="link-compare"><span>compare</span></a>
						<!-- link  wishlish-->

						<!-- link  wishlish-->
						<a href="wishlist.php" class="link-wishlist"><span>wishlish</span></a>
						<!-- link  wishlish-->

						<!-- block mini cart -->
						<div class="block-minicart dropdown">
							<a class="dropdown-toggle" href="orders.php" role="button" data-toggle="dropdown">
								<span class="cart-icon"></span>
								<span class="cart-text">cart</span>
								<span class="counter qty">
									<span class="counter-number" id="cart_number"><?= $this->params['count'];?></span>
									<span class="counter-label"><?= $this->params['count'];?> <span>Item(s)</span></span>
									<span class="counter-price"><?= $this->params['total'];?></span>
								</span>
							</a>
							<div class="dropdown-menu">
								<form>
									<div  class="minicart-content-wrapper" >
										<div class="subtitle">
											You have <span id="cart_number2"><?= $this->params['count'];?></span>&nbsp;item(s) in your cart
										</div>
										<div class="minicart-items-wrapper">
											<ol class="minicart-items" id="cart_item">
												<?php foreach($this->params['products'] as $x):?>
													<li class="product-item">
														<a class="product-item-photo" href="#" title="The Name Product">
															<img class="product-image-photo" src="<?= $path;?>/images/media/index1/minicart.jpg" alt="The Name Product">
														</a>
														<div class="product-item-details">
															<strong class="product-item-name">
																<a href="#"><?= $x->name?></a>
															</strong>
															<div class="product-item-price">
																<span class="price"><?= $this->params[$x->id]['single_price']?></span>
															</div>
															<div class="product-item-qty">
																<span class="label">Qty: </span ><span class="number"><?= $this->params[$x->id]['item_count'][0]?></span>
															</div>
															<div class="product-item-actions">
																<a class="action delete" href="<?=  Url::toRoute(['site/delete-item','product_id'=>$x->prdt_id]);?>" title="Remove item">
																	<span>Remove</span>
																</a>
															</div>
														</div>
													</li>
												<?php endforeach;?>
											</ol>
										</div>
										<div class="subtotal">
											<span class="label">Total</span>
											<span class="price" id="total_cost"><?= $this->params['total'];?></span>
										</div>
										<div class="actions">
												<!-- <a class="btn btn-viewcart" href="">
													<span>Shopping bag</span>
												</a> -->
												<a href="<?= Url::toRoute(['site/view-cart'])?>"><button class="btn btn-checkout" type="button" title="Check Out">
													<span>Checkout</span>
												</button></a>
											</div>
										</div>
									</form>
								</div>
							</div><!-- block mini cart -->


						</div>

						<div class=" nav-mind">

							<!-- block search -->
							<div class="block-search">
								<div class="block-title">
									<span>Search</span>
								</div>
								<div class="block-content">

									<div class="form-search">
										<?php ActiveForm::begin(['id'=>'search_form','method'=>'GET','action'=>Url::toRoute(["/search/search-by-param"])]); ?>
											<div class="box-group">
										<?php
										echo Typeahead::widget([
										    'name' => 'search_key',
										    'id'=>'search_box',
										    'options' => ['placeholder' => 'Search here'],
										    'pluginOptions' => ['hint' => false, 'highlight' => true],
										    'dataset' => [
										        [
										            'local' => $array,
										            'limit' => 10,
										            'templates' => [
									                'notFound' => '<div class="text-danger" style="padding:0 8px">Unable to find ! Please Search by category.</div>',
									            ]
										        ]
										    ]
										]);
										?>
										<button class="btn btn-search" id="srch_btn" type="submit"><span>search</span></button> 
											</div>
										
										
									</div>
									<div class="categori-search  ">
										<select id="category_select" name="category" data-placeholder="All Categories" class="categori-search-option">
											<option selected="true" value="all-categories">All Categories</option>
											<?php foreach($this->params['categories'] as $category):?>
												<option value="<?= $category['slug']?>"><?= $category['name']?></option>
											<?php endforeach;?>
										</select>
									</div>
									<?php ActiveForm::end();?>
								</div>
							</div><!-- block search -->

						</div>
					</div>

				</div>
			</div>
			<!-- header-content -->

			<!-- header-top-right -->
			<div class="header-nav mid-header">

				<div class="container">

					<div class="box-header-nav">

						<span data-action="toggle-nav-cat" class="nav-toggle-menu nav-toggle-cat"><span>Categories</span><i aria-hidden="true" class="fa fa-bars"></i></span>
						<!-- categori -->
							<div class="block-nav-categori">

								<div class="block-title">
									<span>Categories</span>
								</div>

								<div class="block-content">
									<div class="clearfix"><span data-action="close-cat" class="close-cate"><span>Categories</span></span></div>
									<ul class="ui-categori">
										<?php $y = 0;?>
										<?php foreach($this->params['categories'] as $category):?>
											<?php $x = $y>10?'cat-link-orther':''?>
											<li class="parent <?= $x; ?>">
												<a href="<?= Url::toRoute(['search/'.$category['slug']])?>">
													<span class="icon"><img src="<?= $path?>/images/nav-cat1.png" alt="nav-cat"></span>
													<?= $category['name']?>
												</a>
												<?php if(!empty($this->params['sub_category'][$category['cat_id']])):?>
													<span class="toggle-submenu"></span>
													<div class="submenu" style="background-image: url(<?= $path?>/images/nav-cat1.png);">
														<ul class="categori-list clearfix">
															<li class="col-sm-3">
																<strong class="title"><a href="<?= Url::toRoute(['shop/'.$category['slug']])?>"><?= $category['name']?></a></strong>
																<ul>
																	<?php foreach($this->params['sub_category'][$category['cat_id']] as $x):?>
																		<li><a href="<?= Url::toRoute(['shop/'.$category['slug'].'/'.$x['slug']])?>"><?= $x['name']?></a></li>
																	<?php endforeach;?>
																</ul>
															</li>
														</ul>
													</div>
												<?php endif;?>
											</li>
											<?php $y++;?>
										<?php endforeach;?>               
									</ul>

									<div class="view-all-categori">
										<a  class="open-cate btn-view-all">All Categories</a>
									</div>
								</div>

							</div>
						<!-- categori -->
						<?php
							$current_url = Url::to();
							$exploded_string = explode('/', $current_url);
							$slug = $exploded_string[4];
						?>
						<!-- menu -->
							<div class="block-nav-menu">
								<div class="clearfix"><span data-action="close-nav" class="close-nav"><span>close</span></span></div>
								<ul class="ui-menu">
									<li <?= (''==$slug)?'class="active"':'' ?>><a href="<?= Url::toroute(['/'])?>">AutoHome</a></li>
									<li <?= ('shop'==$slug)?'class="active"':'' ?> ><a href="<?= url::toRoute(['/shop'])?>">Shop</a></li>
									<li><a href="#">AutoService</a></li>
									<li><a href="#"> AutoBuy </a></li>
									<li><a href="#"> AutoSell  </a></li>
									<li><a href="#"> Join Us  </a></li>
									<li><a href="contact.php"> Contact Us  </a></li>
									<li><a href="#"> Track Order <span class="label-menu">New</span>  </a></li>

								</ul>

							</div>
						<!-- menu -->
						<span data-action="toggle-nav" class="nav-toggle-menu"><span>Menu</span><i aria-hidden="true" class="fa fa-bars"></i></span>

						<div class="block-minicart dropdown ">
							<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
								<span class="cart-icon"></span>
							</a>
							<div class="dropdown-menu">
								<form>
									<div  class="minicart-content-wrapper" >
										<div class="subtitle">
											You have <span id="cart_number3"><?= $this->params['count'];?></span>&nbsp; item(s) in your cart
										</div>
										<div class="minicart-items-wrapper">
											<ol class="minicart-items" id="cart_item1">
												<?php foreach($this->params['products'] as $x):?>
													<li class="product-item">
														<a class="product-item-photo" href="#" title="The Name Product">
															<img class="product-image-photo" src="<?= $path;?>/images/media/index1/minicart.jpg" alt="The Name Product">
														</a>
														<div class="product-item-details">
															<strong class="product-item-name">
																<a href="#"><?= $x->name?></a>
															</strong>
															<div class="product-item-price">
																<span class="price"><?= $this->params[$x->id]['single_price']?></span>
															</div>
															<div class="product-item-qty">
																<span class="label">Qty: </span ><span class="number"><?= $this->params[$x->id]['item_count'][0]?></span>
															</div>
															<div class="product-item-actions">
																<a class="action delete" href="<?=  Url::toRoute(['site/delete-item','product_id'=>$x->prdt_id]);?>" title="Remove item">
																	<span>Remove</span>
																</a>
															</div>
														</div>
													</li>
												<?php endforeach;?>
											</ol>
										</div>
										<div class="subtotal">
											<span class="label">Total</span>
											<span class="price" id="total_cost1">Rs.<?= $this->params['total'];?></span>
										</div>
										<div class="actions">
											<!-- <a class="btn btn-viewcart" href="">
												<span>Shopping bag</span>
											</a> -->
											<a href="<?= Url::toRoute(['site/view-cart'])?>"><button class="btn btn-checkout" href="orders.php" type="button" title="Check Out">
												<span>Checkout</span>
											</button></a>
										</div>
									</div>
								</form>
							</div>
						</div>
<input type="hidden" id="search_url" value="<?= Url::toRoute(['/search/selection-search']);?>">
						<div class="block-search" id="hover_search">
							<div class="block-title">
								<span>Search</span>
							</div>
							<div class="block-content" id="search_bar">
								<div class="form-search" style="width:1000px; height: 40px;">
									
										<div class="box-group row" >
											
											<div class="categori-search col-md-2 col-sm-2 ">
		<?php $model1 = new CarInfoDropdown();?>
		<?php $form = ActiveForm::begin(['id' => 'search_dropdown-form','action'=>Url::toRoute(['search/dropdown-search'])]); ?>
	<?= $form->field($model1, 'name')->label(false)->dropDownList(
						ArrayHelper::map(CarInfoDropdown::find()
														->select(['ci_id','name'])
														->where(['type'=>1])
														->all(), 'ci_id', 'name'),
	 ['id'=>'brnd-id','prompt'=>'Brand','class'=>'categori-search-option','name'=>'brand',
	  'onchange'=>"
	  var url = $('#search_url').val();
	  var id = $(this).val();
	  	$.post(url+'/'+$(this).val()+'/'+2,function(data){
	  		$('select#model-id').html(data);
	  		$('select#model-id').val(data).trigger('chosen:updated');
	  		$('select#model-id').attr('disabled', false).trigger('chosen:updated');
	  		$('#variant-id').attr('disabled', true).trigger('chosen:updated');
	  	});
	"
	]);
	?>
<?php
$js = <<<JS
$(document).ready(function() {
$('#brnd-id option:first').attr('disabled', true).trigger('chosen:updated');
});
JS;
echo $this->registerJs($js, yii\web\View::POS_READY, 'iCheck-login');
?>
												
											</div>
											<div class="categori-search col-md-2 col-sm-2 ">

	<?= $form->field($model1, 'name')->label(false)->dropDownList(
						ArrayHelper::map(CarInfoDropdown::find()
														->select(['ci_id','name'])
														->where(['type'=>2])
														->all(), 'ci_id', 'name'),
	 ['id'=>'model-id','name'=>'model','prompt'=>'Model','class'=>'categori-search-option','disabled'=>true,
	 'onchange'=>"
	  var url = $('#search_url').val();
	  var id = $(this).val();
	  	$.post(url+'/'+$(this).val()+'/'+3,function(data){
	  		$('select#variant-id').html(data);
	  		$('select#variant-id').val(data).trigger('chosen:updated');
	  		$('select#variant-id').attr('disabled', false).trigger('chosen:updated');
	  	});
	"
	]);
	?>
											
											</div>
										
											<div class="categori-search col-md-2 col-sm-2 ">
	<?= $form->field($model1, 'name')->label(false)->dropDownList(
						ArrayHelper::map(CarInfoDropdown::find()
														->select(['ci_id','name'])
														->where(['type'=>3])
														->all(), 'ci_id', 'name'),
	 ['id'=>'variant-id','name'=>'variant','prompt'=>'Variant','class'=>'categori-search-option','disabled'=>true
	]);
	?>
											</div>
											<div class="col-md-6 col-sm-2">
												<input type="text" class="form-control" placeholder="Search Term..." name="search_field" required="true">

	<?= Html::submitButton('<span>search</span>', ['class' => 'btn btn-search','name'=>'submit_search']) ?>
											</div>
											&nbsp;&nbsp;&nbsp;<i class="fa fa-times" aria-hidden="true" id="close_search" style="cursor: pointer;margin-top: -10px;"></i>
										</div>
										<?php ActiveForm::end();?>

								</div>
							</div>
						</div>

						<div class="dropdown setting">
							<a data-toggle="dropdown" role="button" href="#" class="dropdown-toggle"><span>Settings</span> <i aria-hidden="true" class="fa fa-user"></i></a>
							<div class="dropdown-menu  ">

								<ul class="account list-submenu">
									<li><a href="wishlist.php">Wishlist</a></li>
									<li><a href="profile.php">My Account</a></li>
									<li><a href="<?= Url::toRoute(['site/view-cart'])?>">Checkout</a></li>
									<li><a href="compare.php">Compare</a></li>
									<?php
									if (Yii::$app->user->isGuest) {
										echo "<li><a href=".Url::toRoute(['/users/profile/login']).">Login</a></li>";
										echo "<li><a href=".Url::toRoute(['/users/profile/signup']).">Sign up</a></li>";
									} else {
										echo "<li><a href=".Url::toRoute(['/users/profile/index'])." id='logout_btn'><i class='glyphicon glyphicon-user'></i>&nbsp;&nbsp;".UserModule::t('module', 'Profile')."</a></li>";
										echo '<li>'
										. Html::beginForm(['/users/profile/logout'], 'post')
										. Html::submitButton(
											'<i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp;Logout(' . Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name . ')',
											['id'=>'logout_btn1']
										)
										. Html::endForm()
										. '</li>';
									}
									?>
								</ul>
							</div>
						</div>
			
					</div>
				</div>
				<!-- <div class="dropdown setting " style="background:#fff; top:50px; z-index: -1">
					<div class="container" style="padding-left: 15px;">
						<div class="search-box-tab" style=" height:60px; background: #fff;margin-top: 10px;">
							
							<div class="form-search" style="background: #fff; width: 95%;">
								<form>
									<div class="box-group row" >
										<div class="categori-search col-md-2 col-sm-2">
											<input type="text" class="form-control" placeholder="Search Term...">
											<button class="btn btn-search" type="button"><span>search</span></button>
										</div>
										<div class="categori-search col-md-2 col-sm-2 ">
											<select data-placeholder="Any Car Brand" class="categori-search-option">
												<option>All Brands</option>
												<option>Fashion</option>
												<option>Tops Blouses</option>
												<option>Clothing</option>
												<option>Furniture</option>
												<option>Bathtime Goods</option>
												<option>Shower Curtains</option>
											</select>
										</div>
										<div class="categori-search col-md-2 col-sm-2 ">
											<select data-placeholder="All Models" class="categori-search-option">
												<option>All Models</option>
												<option>Fashion</option>
												<option>Tops Blouses</option>
												<option>Clothing</option>
												<option>Furniture</option>
												<option>Bathtime Goods</option>
												<option>Shower Curtains</option>
											</select>
										</div>
										<div class="categori-search col-md-2 col-sm-2 ">
											<select data-placeholder="All Varients" class="categori-search-option">
												<option>All Varients</option>
												<option>Fashion</option>
												<option>Tops Blouses</option>
												<option>Clothing</option>
												<option>Furniture</option>
												<option>Bathtime Goods</option>
												<option>Shower Curtains</option>
											</select>
										</div>
										<div class="categori-search col-md-2 col-sm-2 ">
											<select data-placeholder="All Categories" class="categori-search-option">
												<option>All Categories</option>
												<option>Fashion</option>
												<option>Tops Blouses</option>
												<option>Clothing</option>
												<option>Furniture</option>
												<option>Bathtime Goods</option>
												<option>Shower Curtains</option>
											</select>
										</div>
										<div class="categori-search  col-md-2 col-sm-2">
											<select data-placeholder="All Categories" class="categori-search-option">
												<option>All Categories</option>
												<option>Fashion</option>
												<option>Tops Blouses</option>
												<option>Clothing</option>
												<option>Furniture</option>
												<option>Bathtime Goods</option>
												<option>Shower Curtains</option>
											</select>
										</div>
									</div>
								</form>
							</div>
							<button type="button" class="close" aria-label="Close" style="top:15px;">
						  <span aria-hidden="true" style="color:#000;">&times;</span>
						</button>
						</div>
					</div>
				</div> -->
	<!-- header-top-right -->

</header>
<!-- end HEADER -->


<div class="container">
	<?= Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>
		<?= Alert::widget() ?>
		<?= $content ?>
	</div>






	<footer class="site-footer footer-opt-1">

		<div class="container">
			<div class="footer-column">

				<div class="row">
					<div class="col-md-3 col-lg-3 col-xs-6 col">
						<strong class="logo-footer">
							<a href=""><img src="<?= $path;?>/images/logo-small.png" alt="logo"></a>
						</strong>

						<table class="address">
							<tr>
								<td><b>Address:  </b></td>
								<td>35, NWA, Main Club Road, Punjabi Bagh West, New Delhi - 110026</td>
							</tr>
							<tr>
								<td><b>Phone: </b></td>
								<td>+ 91 97079 97079</td>
							</tr>
							<tr>
								<td><b>Email:</b></td>
								<td>info@autokartz.com</td>
							</tr>
						</table>
					</div>
					<div class="col-md-2 col-lg-2 col-xs-6 col">
						<div class="links">
							<h3 class="title">Company</h3>
							<ul>
								<li><a href="<?= Url::toRoute(['pages/about-us'])?>" target="_blank">About Us</a></li>
								<li><a href="">Testimonials</a></li>
								<li><a href="">Affiliate Program</a></li>
								<li><a href="<?= Url::toRoute(['pages/shopping-terms-conditions'])?>" target="_blank">Shopping terms & conditions</a></li>
								<li><a href="<?= Url::toRoute(['pages/shipping-return-policy'])?>" target="_blank">Shipping & Return Policy</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-2 col-lg-2 col-xs-6 col">
						<div class="links">
							<h3 class="title">My Account</h3>
							<ul>
								<li><a href="">My Order</a></li>
								<li><a href="">My Wishlist</a></li>
								<li><a href="">My Credit Slip</a></li>
								<li><a href="">My Addresses</a></li>
								<li><a href="">My Account</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-2 col-lg-2 col-xs-6 col">
						<div class="links">
							<h3 class="title">Support</h3>
							<ul>
								<li><a href="<?= Url::toRoute(['pages/privacy-policy'])?>" target="_blank">Privacy Policy</a></li>
								<li><a href="<?= Url::toRoute(['pages/career'])?>" target="_blank">Career</a></li>
								<li><a href="">Refund Policy</a></li>
								<li><a href="">Report Spam</a></li>
								<li><a href="">FAQ</a></li>
								<li><a href="<?= Url::toRoute(['pages/contact-us'])?>" target="_blank">Contact Us</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-3 col-lg-3 col-xs-6 col">
						<div class="block-newletter">
							<div class="block-title">NEWSLETTER</div>
							<div class="block-content">
								<form>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Your Email Address">
										<span class="input-group-btn">
											<button class="btn btn-subcribe" type="button"><span>ok</span></button>
										</span>
									</div>
								</form>
							</div>
						</div>
						<div class="block-social">
							<div class="block-title">Let’s Socialize </div>
							<div class="block-content">
								<a href="" class="sh-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
								<a href="" class="sh-pinterest"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
								<a href="" class="sh-vk"><i class="fa fa-vk" aria-hidden="true"></i></a>
								<a href="" class="sh-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
								<a href="" class="sh-google"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="payment-methods">
				<div class="block-title">
					Accepted Payment Methods
				</div>
				<div class="block-content">
					<img alt="payment" src="<?= $path;?>/images/pay1.jpg">
					<img alt="payment" src="<?= $path;?>/images/pay2.jpg">
					<img alt="payment" src="<?= $path;?>/images/pay3.jpg">
					<img alt="payment" src="<?= $path;?>/images/pay4.jpg">
					<img alt="payment" src="<?= $path;?>/images/pay5.jpg">
					<img alt="payment" src="<?= $path;?>/images/pay6.jpg">
					<img alt="payment" src="<?= $path;?>/images/pay8.jpg">
					<img alt="payment" src="<?= $path;?>/images/pay10.jpg">
				</div>
			</div>

			<div class="footer-links">


				<ul class="links">
					<li><strong class="title">HOT SEARCHED KEYWORDS:</strong></li>
					<li><a href="">Xiaomi Mi3 </a></li>
					<li><a href="">Xiaomi Mi3 </a></li>
					<li><a href="">Xiaomi Mi3 </a></li>
					<li><a href="">Xiaomi Mi3 </a></li>
					<li><a href="">Xiaomi Mi3 </a></li>
					<li><a href="">Xiaomi Mi3 </a></li>
					<li><a href="">Xiaomi Mi3 </a></li>
					<li><a href="">Xiaomi Mi3 </a></li>
					<li><a href="">Xiaomi Mi3 </a></li>
				</ul>


				<?php foreach($this->params['categories'] as $category):?>    
					<ul class="links">
						<li><a href="<?= Url::toRoute(['shop/'.$category['slug']])?>"><strong class="title"><?= $category['name']?> </strong></a></li>
						<?php foreach($this->params['sub_category'][$category['cat_id']] as $x):?>
							<li><a href="<?= Url::toRoute(['shop/'.$category['slug'].'/'.$x['slug']])?>"><?= $x['name']?></a></li>
						<?php endforeach ?>            
					</ul>
				<?php endforeach;?>



			</div>

			<div class="footer-bottom">
				<div class="links">
					<ul>
						<li><a href="">    Company Info – Partnerships    </a></li>
					</ul>
					<ul>
						<li><a href="">Online Shopping </a></li>
						<li><a href="">Promotions </a></li>
						<li><a href="">My Orders  </a></li>
						<li><a href="">Help  </a></li>
						<li><a href="">Site Map </a></li>
						<li><a href="">Customer Service </a></li>
						<li><a href="">Support  </a></li>
					</ul>
					<ul>
						<li><a href="">Most Populars </a></li>
						<li><a href="">Best Sellers  </a></li>
						<li><a href="">New Arrivals  </a></li>
						<li><a href="">Special Products  </a></li>
						<li><a href=""> Manufacturers     </a></li>
						<li><a href="">Our Stores   </a></li>
						<li><a href="">Shipping      </a></li>
						<li><a href="">Payments      </a></li>
						<li><a href="">Payments      </a></li>
						<li><a href="">Refunds  </a></li>
					</ul>
					<ul>
						<li><a href="">Terms & Conditions  </a></li>
						<li><a href="">Policy      </a></li>
						<li><a href="">Policy      </a></li>
						<li><a href=""> Shipping     </a></li>
						<li><a href="">Payments      </a></li>
						<li><a href="">Returns      </a></li>
						<li><a href="">Refunds      </a></li>
						<li><a href="">Warrantee      </a></li>
						<li><a href="">FAQ      </a></li>
						<li><a href="">Contact  </a></li>
					</ul>
				</div>
			</div>

			<div class="copyright">

				Copyright © 2017 AutoKartz Internet (P) Ltd.. All Rights Reserved. In association with <a href="http://www.TradeKartz.com">TradeKartz</a>, <a href="#">AutoGuru</a> and <a href="#">AutoBling</a>

			</div>

		</div>

	</footer>           <!-- end FOOTER -->
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
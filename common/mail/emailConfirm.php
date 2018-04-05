<?php

/* @var $this yii\web\View */
/* @var $user modules\users\models\User */

use yii\helpers\Html;
use yii\helpers\Url;
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['profile/email-confirm', 'token' => $user->email_confirm_token]);
$path = Url::base(true);
?>
<!DOCTYPE html>
<html>
<head>
	
</head>
<style type="text/css">
body{background-color: #88BDBF;margin: 0px;}
</style>
<body>
	<table border="0" width="70%" style="margin:auto;padding:30px;background-color: #F3F3F3;border:1px solid #FF7A5A;">
		<tr>
			<td>
				<table border="0" width="100%">
					<tr>
						<td>
							<h1><img src="http://woocommerce-153819-442074.cloudwaysapps.com/wp-content/uploads/2018/01/ak_new_head_200.png"></h1>
						</td>
						<td>
							<p style="text-align: right;"><a href="www.autokartz.com" target="_blank" style="text-decoration: none;">View In Website</a></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table border="0" cellpadding="0" cellspacing="0" style="text-align:center;width:100%;background-color: #fff;">
					<tr>
						<td style="background-color:#FF7A5A;height:100px;font-size:50px;color:#fff;"><img src="https://cdn3.iconfinder.com/data/icons/social-media-logos-flat-colorful/2048/5303_-_Gmail-128.png" ></td>
					</tr>
					<tr>
						<td>
							<h1 style="padding-top:25px;">Email Confirmation</h1>
						</td>
					</tr>
					<tr>
						<td style="text-align:left;padding-left: 4%;padding-right: 4%">
							<p style="padding:0px 100px;">
								<h3>Hello ! <b><?= Html::encode($user->first_name." ".$user->last_name) ?>,</b></h3>
								<p>Welcome to the Autokartz.com.
								Buy Auto Spare Parts & Accessories at best price only on Autokartz - India's Leading Spare Parts & Accessories Space enabling express delivery of 100% genuine spare parts & accessories in India.</p>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<button style="margin:10px 0px 30px 0px;border-radius:4px;padding:10px 20px;border: 0;color:#fff;background-color:#FF7A5A; "><a href="<?= $confirmLink?>" style="text-decoration: none; color: #fff">Verify Email Address</a></button>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table border="0" width="100%" style="border-radius: 5px;text-align: center;">
					<tr>
						<td>
							<h3 style="margin-top:10px;">Stay in touch</h3>
						</td>
					</tr>
					<tr>
						<td>
							<div style="margin-top:20px;">
								<a href="https://www.facebook.com/autokartzcom/" style="text-decoration: none;"><img src="https://cdn2.iconfinder.com/data/icons/social-icons-circular-color/512/fb-128.png" style="height:40px;width:40px;margin-top:20px;"></a>
								<a href="https://twitter.com/autokartz" style="text-decoration: none;"><img src="https://cdn3.iconfinder.com/data/icons/basicolor-reading-writing/24/077_twitter-128.png" style="height:40px;width:40px;margin-top:20px;"></a>
								<a href="https://plus.google.com/108504089405765952866" style="text-decoration: none;"><img src="https://cdn0.iconfinder.com/data/icons/lumin-social-media-icons/512/Gmail-128.png" style="height:40px;width:40px;margin-top:20px;"></a>
								<a href="https://www.linkedin.com/company/autokartz-com" style="text-decoration: none;"><img src="https://cdn2.iconfinder.com/data/icons/social-icons-circular-color/512/linkedin-128.png" style="height:40px;width:40px;margin-top:20px;"></a>
								<a href="#" style="text-decoration: none;"><img src="https://cdn2.iconfinder.com/data/icons/social-icons-circular-color/512/pinterest-128.png" style="height:40px;width:40px;margin-top:20px;"></a>
					</div>
						</td>
					</tr>
					<tr>
						<td>
							<div style="margin-top: 20px;">
								<span style="font-size:12px;"><b>Autokartz.com</b></span><br>
								<span style="font-size:12px;">Copyright © 2015 Autokartz.com</span>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
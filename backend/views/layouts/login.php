<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\LoginAsset;
use kartik\widgets\Growl;

LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::$app->name . ' | ' . Html::encode($this->title) ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php $this->head() ?>
</head>
<body class="hold-transition login-page">
<?php $this->beginBody() ?>
<div class="row">
    <div class="col-md-12">
        <?php foreach (Yii::$app->session->getAllFlashes() as $message):
			if(!empty($message['type']) && !empty($message['message'])):
				echo \kartik\widgets\Growl::widget([
					'type' => $message['type'],
					'title' => 'AutoKartz!',
					'body' => Html::encode($message['message']),
					'showSeparator' => true,
					'delay' => 300, //This delay is how long before the message shows
					'pluginOptions' => [
						'delay' => 3000, //This delay is how long the message shows for
						'placement' => [
							'from' => 'top',
							'align' => 'right',
						]
					]
				]);
			endif;
		endforeach; ?>
    </div>
</div>
<div class="login-box">
    <div class="login-logo">
        <a href="<?= Yii::$app->homeUrl ?>">Welcome to <b><?= Yii::$app->name ?></b></a>
    </div>
    <div class="login-box-body">
        <?= $content ?>
    </div>
    <div class="login-box-footer">
        <a class="btn btn-success" href="<?= Url::to(Yii::$app->urlManagerBackend->createUrl('')); ?>"><?= Yii::t('app', 'Go to AutoKartz.com'); ?></a>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

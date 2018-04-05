<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\LockAsset;
use kartik\widgets\Growl;

LockAsset::register($this);
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
<body class="hold-transition lockscreen">
<?php $this->beginBody() ?>
<div class="login-box">
 <div class="lockscreen-logo">
    <a href="<?= Url::toRoute([''])?>"><b>Autokartz</b>CRM</a>
  </div>
  <!-- User name -->
  <?= $content;?>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Enter your password to retrieve your session
  </div>
  <div class="text-center">
    <a href="<?= Url::toRoute(['/users/login'])?>">Or sign in as a different user</a>
  </div>
  <div class="lockscreen-footer text-center">
    Copyright &copy; 2014-2018 <b><a href="<?= Url::to(Yii::$app->urlManagerBackend->createUrl('')); ?>" target="_blank" class="text-black">Autokartz Internet India Pvt. Ltd.</a></b><br>
    All rights reserved
  </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

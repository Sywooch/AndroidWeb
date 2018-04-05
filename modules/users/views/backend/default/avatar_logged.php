<?php

use yii\helpers\Html;

/* @var $model modules\users\models\backend\User */
$path = Yii::$app->urlManagerBackend->createUrl('');
$image_path = $model->avatarPath;
$main_path = $path.$image_path;
?>

<?php if ($path = $model->avatarPath) : ?>
    <div class="row">
        <div class="col-sm-12 text-center">
            <?= Html::img($main_path, [
                'class' => 'profile-user-img img-responsive img-circle',
                'style' => 'width:60px',
                'alt' => 'avatar_' . $model->username,
            ]); ?>
			<?php if ($model->islogged == 1) : ?>
				<span class="label label-success">Online</span>
			<?php else : ?>
				<span class="label label-danger">Offline</span>
			<?php endif; ?>
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-sm-12 text-center">
            <?= $model->getGravatar(null, 80, 'mm', 'g', true, [
                'class' => 'profile-user-img img-responsive img-circle',
                'style' => 'width:60px',
                'alt' => 'avatar_' . $model->username,
            ]); ?>
			<?php if ($model->islogged == 1) : ?>
				<span class="label label-success">Online</span>
			<?php else : ?>
				<span class="label label-danger">Offline</span>
			<?php endif; ?>
        </div>
    </div>
<?php endif; ?>

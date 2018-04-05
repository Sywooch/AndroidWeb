<?php

/* @var $this yii\web\View */
/* @var $user modules\users\models\User */

use yii\helpers\Html;
use common\models\User;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['profile/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->email) ?>,</p>
    <p>FOLLOW_TO_RESET_PASSWORD <?= Html::encode($user->email) ?>,</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>

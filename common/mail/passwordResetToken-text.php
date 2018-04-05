<?php

/* @var $this yii\web\View */
/* @var $user modules\users\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['users/profile/reset-password', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->first_name.' '.$user->last_name ?>,

Follow the link below to reset your password:

<?= $resetLink ?>

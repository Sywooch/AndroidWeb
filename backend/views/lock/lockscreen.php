 <?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\users\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use modules\users\Module;
?>

 <div class="lockscreen-name"><?= $model->full_name?></div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
    <?php if($path == null) :?>
      <img src="http://www.descartesbiometrics.com/wp-content/uploads/2014/12/secure-profile-icon.png" alt="User Image">
      <?php endif;?>
  <?php if($path != null):?>
  <img src="<?= $path;?>" alt="User Image">
  <?php endif;?>
    </div>
  
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'validateOnBlur' => false,
            'action' => ['/users/login','previous'=>$previous],
            'options' => [
                'class' => 'lockscreen-credentials'
             ]
        ]); ?>
      <div class="input-group">
        <?= $form->field($model, 'password')->passwordInput(['style'=>'margin-top:-5px'])->label(false); ?>
         <div style="display: none;">
            <?php    
              echo Html::activeHiddenInput($model, 'email');
            ?>
        </div>
        <div class="input-group-btn">
           <?= Html::submitButton('<i class="fa fa-arrow-right text-muted"></i>', ['class' => 'btn', 'name' => 'login-button']) ?>
        </div>
      </div>
   <?php ActiveForm::end(); ?>
    <!-- /.lockscreen credentials -->

  </div>                      

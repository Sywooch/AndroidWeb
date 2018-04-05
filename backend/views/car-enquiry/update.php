<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AppCarEnquiry */

$this->title = 'Manage Pending Enquiries';
$this->params['breadcrumbs'][] = ['label' => 'Pending Enquiries', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="app-car-enquiry-update">
     <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title); ?></h3>
        </div>
        <?= $this->render('manage-pending-enq', [
			'model' => $model,
			'model1' => $model1,
			'model2' => $model2,
            'enq_id'=>$enq_id,
            'userData'=>$userData,
		]) ?>
    </div>

</div>

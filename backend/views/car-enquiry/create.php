<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AppCarEnquiry */

$this->title = 'Create App Car Enquiry';
$this->params['breadcrumbs'][] = ['label' => 'App Car Enquiries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-car-enquiry-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

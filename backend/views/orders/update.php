<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AppProductOrders */

$this->title = 'Update App Product Orders: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'App Product Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_id, 'url' => ['view', 'id' => $model->order_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="app-product-orders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

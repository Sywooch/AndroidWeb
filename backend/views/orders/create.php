<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AppProductOrders */

$this->title = 'Create App Product Orders';
$this->params['breadcrumbs'][] = ['label' => 'App Product Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-product-orders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

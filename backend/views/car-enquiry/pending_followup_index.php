<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AppCarEnquirySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'App Car Enquiries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-car-enquiry-index">
    
  <?php 
    $gridColumn = [
        ['class' => 'kartik\grid\SerialColumn'],
        ['attribute' => 'brnd_id', 'visible' => false],
       // 'user_id',
        [   
            'attribute'=>'garage_owner_name',
            'label'=>'Garage Owner Name',
            'value'=>'userName.garage_owner_name'
        ],
        'car_chassis_number',
        'brand',
        'model',
        'variant',
        'engine',
        'year',
        [
            'attribute'=>'created_at',
            'value'=>function($data){
                return Yii::$app->formatter->asDatetime($data->created_at, 'd LLL yyyy');
            },
            'format'=>'raw',
            'filter'=>DatePicker::widget([
                'model' => $searchModel,
                'type' => DatePicker::TYPE_INPUT,
                'attribute' => 'created_time',
                'pjaxContainerId'=>'kv-pjax-container-category',
                'data' => [
                    'pjax' => 0,
                ],
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'format' => 'd M yyyy'
                    ]
            ])
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'template'=>'{add}   {view}',
            'buttons'=>[
                'add' => function ($url, $model) {     
                return Html::a('<i class="glyphicon glyphicon-plus-sign"></i>', ['car-enquiry/manage-pending-followup?id='.$model->id]);  
                }
            ],
        ],
    ]; 
    ?>
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'tableOptions' => [
            'class' => 'table table-bordered table-hover',
        ],
        'responsive'=>true,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-category']],
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => Html::encode($this->title),
        ],
       'toolbar'=> [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                '{toggleData}'.
                '{export}'
            ],
        ], 
    ]); ?>
   
</div>

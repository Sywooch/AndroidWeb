<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AppCarEnquiry */

$this->params['breadcrumbs'][] = ['label' => 'App Car Enquiries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-car-enquiry-view">
 <div class="box" style="margin-top: 20px;">
      
<div class="row">
        <div class="col-sm-9">
             <h2>&nbsp;<?= "Enquiry Id:#".Html::encode($model->id); ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            <?=             
             Html::a('<i class="glyphicon glyphicon-hand-up"></i> ' . 'PDF', 
                ['pdf', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'title' => 'Will open the generated PDF file in a new window'
                ]
            )?>
        </div>
    </div><hr style="margin-bottom: 0px; margin-top: 10px;">
        <div class="row">   
            <div class="col-sm-12">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'user_id',
                        'car_chassis_number',
                        'brand',
                        'model',
                        'variant',
                        'engine',
                        'year',
                        [
                            'attribute' => 'status',
                            'label'=>'Enquiry Status',
                            'format' => 'raw',
                            'value'=>function($model){
                                if($model->status == 1){
                                    return "Pending Enquiries";
                                }else if($model->status == 2){
                                    return "Pending Followups";
                                }else if($model->status == 3){
                                    return "Not Available";
                                }else{
                                    return "Completed";
                                }
                            },
                            
                        ],
                        [
                            'attribute' => 'reason',
                            'label'=>'Complete Reason',
                            'format' => 'raw',
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php
	
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\widgets\DatePicker;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $searchModel modules\users\models\backend\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-backend-default-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
		[
			'attribute' => 'avatar',
			'label' => Module::t('module', 'Avatar'),
			'format' => 'raw',
			'value' => function ($data) {
				return $this->render('avatar_logged', ['model' => $data]);
			},
			'headerOptions' => [
				'width' => '120',
			],
		],
		[
			'attribute' => 'fullName',
			'label' => Module::t('module', 'Name'),
			'format' => 'raw',
		],
		[
			'attribute' => 'email',
			'format' => 'email'
		],
		[
			'attribute' => 'mobile',
		],
		[
			'attribute' => 'status',
			'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->statusesArray, [
				'class' => 'form-control',
				'prompt' => Module::t('module', '- all -'),
				'data' => [
					'pjax' => true,
				],
			]),
			'format' => 'raw',
			'value' => function ($data) {
				if ($data->id != Yii::$app->user->identity->getId()) {
					$this->registerJs("$('#status_link_" . $data->id . "').click(handleAjaxLink);", \yii\web\View::POS_READY);
					return Html::a($data->statusLabelName, Url::to(['status', 'id' => $data->id]), [
						'id' => 'status_link_' . $data->id,
						'title' => Module::t('module', 'Click to change the status'),
						'data' => [
							'toggle' => 'tooltip',
							'pjax' => 0,
						],
					]);
				}
				return $data->statusLabelName;
				},
			'headerOptions' => [
				'class' => 'text-center',
				'width' => '10%',
			],
			'contentOptions' => [
				'class' => 'title-column',
			],
		],
		[
			'attribute' => 'last_visit',
			'format' => 'raw',
			'filter' => DatePicker::widget([
				'language' => Yii::$app->language,
				'model' => $searchModel,
				'attribute' => 'date_from',
				'attribute2' => 'date_to',
				'options' => ['placeholder' => Module::t('module', '- start -')],
				'options2' => ['placeholder' => Module::t('module', '- end -')],
				'type' => DatePicker::TYPE_RANGE,
				'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
				'pluginOptions' => [
					'todayHighlight' => true,
					'format' => 'dd-mm-yyyy',
					'autoclose' => true,
				]
			]),
			'value' => function ($data) {
				return Yii::$app->formatter->asDatetime($data->last_visit, 'd LLL yyyy, H:mm:ss');
			},
			'headerOptions' => [
				'class' => 'text-center',
				'width' => '16%',
			],
			'contentOptions' => [
				'class' => 'text-center',
				],
		],
        [
            'class' => 'yii\grid\ActionColumn',
			'template'=>'{view} {update} {delete}',
			'buttons'=>[
				'delete' => function ($url, $model) {
					$linkOptions = [
						'title' => Module::t('module', 'Delete'),
						'data' => [
							'toggle' => 'tooltip',
							'method' => 'post',
							'pjax' => 0,
							'confirm' => Module::t('module', 'The user "{:name}" will be marked as deleted!', [':name' => $model->username]),
						]
					];
					if ($model->isDeleted()) {
						$linkOptions = [
							'title' => Module::t('module', 'Delete'),
							'data' => [
								'toggle' => 'tooltip',
								'method' => 'post',
								'pjax' => 0,
								'confirm' => Module::t('module', 'You won\'t be able to revert this!'),
							],
						];
					}
					return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $linkOptions);
				},
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
            'heading' => '<i class="fa fa-users"></i>  ' . Html::encode($this->title),
        ],
       'toolbar'=> [
			['content'=>
				Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
				['role'=>'modal-remote','title'=> 'Create User','class'=>'btn btn-success']).
				Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
				['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
				'{toggleData}'.
				'{export}'
			],
		], 
    ]); ?>

</div>
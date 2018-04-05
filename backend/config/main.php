<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
	'name' => 'AutoKartz CRM',
    //'homeUrl' => '/akdoit/backend/web',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'main/default/index',
    'bootstrap' => [
        'log',
        'modules\main\Bootstrap',
        'modules\users\Bootstrap',
        'modules\rbac\Bootstrap',
    ],
    'modules' => [
        'main' => [
            'isBackend' => true,
        ],
        'users' => [
            'isBackend' => true,
        ],
        'rbac' => [
            'class' => 'modules\rbac\Module',
            'params' => [
                'userClass' => 'modules\users\models\User',
            ]
        ],
		'gridview' => [
			'class' => '\kartik\grid\Module',
		],
		'datecontrol' => [
			'class' => '\kartik\datecontrol\Module',
		]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/backend/web',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist',
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => '@vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist',
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ]
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'modules\users\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['/users/default/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'backend/error',
            
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
           // 'enableStrictParsing' => true,
            'rules' => [
                'car-enquiry/part-details/<part_id:\d+>/<enq_id:\d+>' => 'car-enquiry/part-details',
                'car-enquiry/suggested-product/<enquiry_product_id:\d+>' => 'car-enquiry/suggested-product',
				'car-enquiry/agent-logs/<enquiry_product_id:\d+>' => 'car-enquiry/agent-logs',
				'defaultRoute' => '/',
			], 
        ],
		'urlManagerBackend' => [ 
			'class' => 'yii\web\urlManager', 
			'enablePrettyUrl' => true, 
			'showScriptName' => false, 
			'baseUrl' => '/frontend/web', 
		],
    ],
	
    'as afterAction' => [
        'class' => '\modules\users\components\behavior\LastVisitBehavior',
    ],
    
    'as AccessBehavior' => [
        'class' => '\modules\rbac\components\behavior\AccessBehavior',
        'permission' => \modules\rbac\models\Permission::PERMISSION_VIEW_ADMIN_PAGE, // Allow access to the admin area
    ],
    'params' => $params,
];

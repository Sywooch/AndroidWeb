<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
	'name' => 'AutoKartz.com',
    //'homeUrl' => '/akdoit/frontend/web',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'modules\main\Bootstrap',
        'modules\users\Bootstrap',
        'modules\rbac\Bootstrap',
    ],
  // 'defaultRoute' => 'main/default/index',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
           // 'baseUrl' => '/akdoit/frontend/web',
        ],
        'assetManager' => [
           'bundles' => [
               'yii\web\JqueryAsset' => [
                   'sourcePath' => null,
                   'basePath' => '@webroot',
                   'baseUrl' => '@web',
                   'js' => [
                       'js/jquery.min.js',
                       'js/aksuper.js',
                   ],
               ],
           ],
       ],
        'user' => [
            'identityClass' => 'modules\users\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => ['/login'],
        ],
        'session' => [
            'name' => 'advanced-frontend',
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
            'errorAction' => 'frontend/error',
            // 'class' => '\bedezign\yii2\audit\components\web\ErrorHandler',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            'rules' => [
              ''=>'site/index'
            ],
        ],
    ],
    'as afterAction' => [
        'class' => '\modules\users\components\behavior\LastVisitBehavior',
    ],
    'params' => $params,
];

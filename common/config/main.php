<?php
return [
	'language'=>'en-US',
	'timeZone' => 'Asia/Kolkata',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'main' => [
            'class' => 'modules\main\Module',
        ],
        'users' => [
            'class' => 'modules\users\Module',
        ],
        'rbac' => [
            'class' => 'modules\rbac\Module',
        ],
        // 'class' => '\bedezign\yii2\audit\components\web\ErrorHandler',
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=nameDb',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            //'defaultRoles' => ['garage_owner'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'useFileTransport' => false,
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'basePath' => '@app/web/assets',
        ],
		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			'dateFormat' => 'php:M d, Y',
			'datetimeFormat' => 'php:M d, Y, H:i:s',
			'timeFormat' => 'php:H:i:s',
		],
    ],
];

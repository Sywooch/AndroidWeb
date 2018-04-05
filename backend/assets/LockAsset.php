<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class LoginAsset
 * @package backend\assets
 */
class LockAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
    	 'css/login.css',
    ];

    public $js = [];

    public $depends = [
    	 'backend\assets\LoginAdminLteAsset',
    ];
}

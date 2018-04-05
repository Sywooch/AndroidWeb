<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class AdminLteAsset
 * @package backend\assets
 */
class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = [
            'css/AdminLTE' . $min . '.css',
            'css/skins/_all-skins' . $min . '.css',
        ];
        $this->js = [
            'js/adminlte' . $min . '.js'
        ];
    }

    public $depends = [];
}

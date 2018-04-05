<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/site.css',
        'css/custom.css',
        'css/bootstrap-social.css'
    ];
    public $js = [
        //'js/jquery.min.js',
        //'js/aksuper.js',
        'js/jquery.sticky.js',
        'js/owl.carousel.min.js',
        'js/jquery.countdown.min.js',
        'js/jquery.bxslider.min.js',
        'js/jquery.actual.min.js',
        'js/jquery-ui.min.js',
        'js/chosen.jquery.min.js',
        'js/jquery.parallax-1.1.3.js',
        'js/jquery.elevateZoom.min.js',
        'js/fancybox/source/jquery.fancybox.pack.js',
        'js/fancybox/source/helpers/jquery.fancybox-media.js',
        'js/fancybox/source/helpers/jquery.fancybox-thumbs.js',
        'js/arcticmodal/jquery.arcticmodal.js',
        'js/typeahead.bundle.js',
        'js/custom.js',
        'js/main.js',
        //'js/aksuper.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\FontAwesomeAsset',

        'common\assets\Html5ShivAsset',
        'common\assets\RespondAsset'
    ];
}

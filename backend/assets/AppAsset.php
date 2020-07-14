<?php

namespace backend\assets;

use yii\web\AssetBundle;


/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/css/site.css',
        '/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.css',
    ];
    public $js = [
        '/plugins/layer-v3.1.1/layer/layer.js',
        '/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\CommonAsset',
    ];
}

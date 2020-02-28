<?php

namespace backend\themes\basic\assets;

use yii\web\AssetBundle;


/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = "@webroot";
    public $baseUrl = "@themes_static/basic";
    public $css = [
        'css/site.css',
        "css/bootstrap.min.css",
        "css/dashboard.css",
    ];
    public $js = [
        "js/bootstrap.min.js",
        "js/ie10-viewport-bug-workaround.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
        'common\assets\CommonAsset',
    ];
}

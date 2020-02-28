<?php

namespace backend\assets;

use yii\web\AssetBundle;


/**
 * Main backend application asset bundle.
 */
class DatePackerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/plugins/datepicker/css/bootstrap-datepicker3.css',
    ];
    public $js = [
        'http://cdn.bootcss.com/jquery/1.11.0/jquery.min.js',
        '/plugins/datepicker/js/bootstrap-datepicker.min.js',
        '/plugins/datepicker/js/bootstrap-datepicker.zh-CN.min.js',
        'http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\CommonAsset',
    ];
}

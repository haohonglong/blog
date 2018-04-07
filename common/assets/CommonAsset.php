<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class CommonAsset extends AssetBundle
{
    public $sourcePath = '@common/';
    public $css = [
        'css/global.css'
    ];
    public $js = [
        'js/vue.js',
    ];
    public $depends = [

    ];
}

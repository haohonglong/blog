<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class CommonAsset extends AssetBundle
{
    public $sourcePath = '@common/css';
    public $css = [
        'global.css'
    ];
    public $js = [
    ];
    public $depends = [

    ];
}

<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 31/03/2018
 * Time: 12:10 PM
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '视频';
$this->params['breadcrumbs'][] = $this->title;


?>
<style type="text/css">
    .thumbnail{height: 542px;}
    .thumbnail .video{height: 400px;}
    .thumbnail .caption{height: 130px;position: relative;}
    .thumbnail .caption .btn{position: absolute;bottom:0;left:0;}
    .thumbnail *{width:100%;}
    .thumbnail h3{font-size: 12px;}
</style>
<script type="text/javascript">
    <?php $this->beginBlock('js'); ?>
    LAM.run([jQuery],function ($) {
        'use strict';
        var System = this;



    });

    <?php $this->endBlock(); ?>
</script>

<?php $this->registerJs($this->blocks['js'], \yii\web\View::POS_END); //将编写的js代码注册到页面底部  ?>
<div class="row MB20">
    <div class="col-md-7">

    </div>
    <div class="col-md-5 text-right">
        <a href="<?=Url::to(['/video/add'])?>" class="btn btn-primary btn-sm active" role="button">添加视频</a>
    </div>
</div>


<div class="row">
    <?php foreach ($list as $item):?>
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <div class="video">
                <?=Html::decode($item['source'])?>
            </div>
            <div class="caption">
                <h3>
                    <?=Html::encode($item['title'])?>
                    <a href="<?=Url::to(['/video/edit','id'=>$item['id']])?>" class="btn btn-primary btn-sm">修改</a>
                </h3>

            </div>
        </div>
    </div>
    <?php endforeach;?>
</div>


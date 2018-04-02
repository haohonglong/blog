<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 31/03/2018
 * Time: 12:10 PM
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '类别';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row MB20">
    <div class="col-md-7">
        <?php $form = ActiveForm::begin(['action'=>'/sorts/index']);?>
        <div class="input-group" style="width:50%;">
            <input type="text" name="keyword" class="form-control" placeholder="输入类别名称关键字">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">搜索</button>
          </span>
        </div><!-- /input-group -->
        <?php ActiveForm::end();?>
    </div>
    <div class="col-md-5 text-right">
        <a href="<?=Url::to(['/sorts/add'])?>" class="btn btn-primary btn-sm active" role="button">添加类别</a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php foreach ($list as $item):?>
        <a href="<?=Url::to(['sorts/edit','id'=>$item['id']]);?>" class="label label-primary" style="font-size:105%;"><?=$item['name']?></a>
        <?php endforeach;?>
    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 31/03/2018
 * Time: 12:10 PM
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '网页地址';
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
        <a href="<?=Url::to(['/link-address/add'])?>" class="btn btn-primary btn-sm active" role="button">添加地址</a>
    </div>
</div>



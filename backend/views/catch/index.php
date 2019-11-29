<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 31/03/2018
 * Time: 12:10 PM
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '抓取模版';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row MB20">
    <div class="col-md-7">
        <?php $form = ActiveForm::begin();?>
        <div class="input-group" style="width:100%;">
            <input type="text" name="url" class="form-control" placeholder="网站地址">
        </div>
        <div class="input-group" style="width:100%;margin-top:20px;">
            <input type="text" name="path" class="form-control" placeholder="保存路径">
        </div>

        <div class="input-group" style="text-align: right;margin-top:20px;">
                <button class="btn btn-default" type="submit">抓取</button>
        </div>
        <?php ActiveForm::end();?>
    </div>

</div>



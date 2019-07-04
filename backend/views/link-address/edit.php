<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


$this->title = '地址链接';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="text-right"></div>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'article-form']); ?>
            <?php $a = Html::a('添加类别',Url::to(['/sorts/add']),['class'=>'btn btn-primary btn-sm active ML10']);?>
            <?= $form->field($model, 'sorts_id',['template'=>'{label} <br /> {input}'.$a.'{hint}{error}'])->dropDownList($sorts,['value' => isset($sortid) ? $sortid : '','prompt'=>'请选择','style'=>'width:15%;display:inline-block;']) ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true,'style'=>'width:25%;']) ?>
            <?= $form->field($model, 'url')->textInput() ?>
            <?= $form->field($model, 'info')->textarea(['style'=>'height:20em;']) ?>

            <div class="form-group text-right MT20">
                <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

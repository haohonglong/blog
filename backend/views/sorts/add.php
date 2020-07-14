<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = '添加类别';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p></p>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'article-form']); ?>
            <?= $form->field($model, 'pid')->dropdownList(ArrayHelper::map($list,'id','name'),['prompt'=>['text' => '一级', 'options' => ['value' => 0]],'style'=>'width:25%;']) ?>
            <?= $form->field($model, 'name')->textInput(['autofocus' => true,'style'=>'width:25%;']) ?>
            <?= Html::submitButton('添加', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

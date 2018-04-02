<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '修改文章';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p></p>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'article-form']); ?>
            <?= $form->field($model, 'sorts_id')->dropDownList($sorts,['style'=>'width:15%;']) ?>
            <?= $form->field($model, 'title')->textInput(['autofocus' => true,'style'=>'width:25%;']) ?>

            <?= froala\froalaeditor\FroalaEditorWidget::widget([
                'model' => $model,
                'attribute' => 'content',
                'options' => [
                    // html attributes
                    'id'=>'content'
                ],
                'clientOptions' => [
                    'width'=>'100%',
                    'toolbarInline' => false,
                    'theme' => 'royal', //optional: dark, red, gray, royal
                    'language' => 'zh_cn' // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
                ]
            ]); ?>


            <div class="form-group text-right MT20">
                <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

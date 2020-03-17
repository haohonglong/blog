<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoodsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-list-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="form-group">
            <div class="col-sm-1"><?= $form->field($model, 'id') ?></div>
            <div class="col-sm-3"><?= $form->field($model, 'shop[name]') ?></div>
            <div class="col-sm-3"><?= $form->field($model, 'name') ?></div>
            <div class="col-sm-1"><?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary','style'=>'margin-top:25px;']) ?></div>
            <div class="col-sm-1"><?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default','style'=>'margin-top:25px;']) ?></div>
        </div>
    </div>


    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'single_price') ?>

    <?php // echo $form->field($model, 'final_price') ?>

    <?php // echo $form->field($model, 'create_by') ?>

    <?php // echo $form->field($model, 'update_by') ?>



    <?php ActiveForm::end(); ?>

</div>

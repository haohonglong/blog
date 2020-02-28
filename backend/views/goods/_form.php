<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use backend\assets\DatePackerAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\Goods */
/* @var $form yii\widgets\ActiveForm */

DatePackerAsset::register($this);
?>
<script type="text/javascript">
    <?php $this->beginBlock('js')?>
    $('input[data-provide]').datepicker({
        language: 'zh-CN',
        todayBtn: 'linked',
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    <?php $this->endBlock();?>
</script>
<?php $this->registerJs($this->blocks['js']);?>


<div class="shop-list-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="form-group">
            <div class="col-sm-1">
                <?= Html::a('添加商店', ['shop/create'], ['class' => 'btn btn-success','style'=>'margin-top:25px;']) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'shop_id')->dropdownList($shops,['prompt'=>'选择商店名称']); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'create_by')->textInput(['data-provide'=>'datepicker']) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'update_by')->textInput(['data-provide'=>'datepicker']) ?>
            </div>
            <div class="col-sm-2">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success','style'=>'margin-top:25px;']) ?>
            </div>
        </div>
    </div>
    <div id="goods_div">
        <div class="row">
            <div class="form-group">
                <div class="col-sm-2"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
                <div class="col-sm-1"><?= $form->field($model, 'number')->textInput(['value'=>1,'class'=>'form-control number']) ?></div>
                <div class="col-sm-1"><?= $form->field($model, 'weight')->textInput() ?></div>
                <div class="col-sm-1"><?= $form->field($model, 'single_price')->textInput(['maxlength' => true,'class'=>'form-control single_price']) ?></div>
                <div class="col-sm-1"><?= $form->field($model, 'final_price')->textInput(['maxlength' => true,'class'=>'form-control final_price']) ?></div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>



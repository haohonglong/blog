<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use backend\assets\DatePackerAsset;
/* @var $this yii\web\View */
/* @var $model backend\models\Goods */
/* @var $form yii\widgets\ActiveForm */

DatePackerAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\models\Goods */

$this->title = Yii::t('app', '添加商品');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '商品列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">
    <?php $this->beginBlock('js')?>
    $('input[data-provide]').datepicker({
        language: 'zh-CN',
        todayBtn: 'linked',
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    var html = $('#templ_goods').html();
    var $goods_div = $('#goods_div');
    var $total = $('#total');
    var total = 0;
    $('#addition_goods').on('click',function() {
        $goods_div.append(html);
    });

    $(document).on('click','.del_goods',function () {
        $(this).closest('.row').remove();
    });


    $(document).on('click','.final_price',function() {
        $row = $(this).closest('.row');
        var price = $('.single_price',$row).val() * $('.number',$row).val() * $('.weight',$row).val();
        price = parseFloat(price).toFixed(2);
        total = parseFloat(total);
        price = parseFloat(price);
        total += price;
        $(this).val(price);
        $total.text(total);
    });


    <?php $this->endBlock();?>
</script>
<?php $this->registerJs($this->blocks['js']);?>
<div class="shop-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="shop-list-form">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="form-group">
                <div class="col-sm-1">
                    <?= Html::a('添加商店', ['shop/create'], ['class' => 'btn btn-success','style'=>'margin-top:25px;']) ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'shop_id')->dropdownList($shops,['prompt'=>'选择商店名称'])->label('超市名称'); ?>
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
                <div class="col-sm-1"><a class="btn btn-success" id="addition_goods" href="javascript:void();" style="margin-top:38%;">增加一个商品</a></div>
            </div>
        </div>
        <div id="goods_div">
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-2"><?= $form->field($model, 'name[]')->textInput(['maxlength' => true]) ?></div>
                    <div class="col-sm-1"><?= $form->field($model, 'number[]')->textInput(['value'=>1,'class'=>'form-control number']) ?></div>
                    <div class="col-sm-1"><?= $form->field($model, 'weight[]')->textInput(['value'=>1,'class'=>'form-control weight']) ?></div>
                    <div class="col-sm-1"><?= $form->field($model, 'single_price[]')->textInput(['maxlength' => true,'class'=>'form-control single_price']) ?></div>
                    <div class="col-sm-1"><?= $form->field($model, 'final_price[]')->textInput(['maxlength' => true,'class'=>'form-control final_price']) ?></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                总金额: <span id="total">0.00</span>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <script id="templ_goods" type="text/html">
        <div class="row">
            <div class="form-group">
                <div class="col-sm-2"><div class="form-group field-goods-name required">
                        <label class="control-label" for="goods-name">名称</label>
                        <input type="text" id="goods-name" class="form-control" name="Goods[name][]" maxlength="255">

                        <div class="help-block"></div>
                    </div></div>
                <div class="col-sm-1"><div class="form-group field-goods-number">
                        <label class="control-label" for="goods-number">数量</label>
                        <input type="text" id="goods-number" class="form-control number" name="Goods[number][]" value="1">

                        <div class="help-block"></div>
                    </div></div>
                <div class="col-sm-1"><div class="form-group field-goods-weight required">
                        <label class="control-label" for="goods-weight">重量</label>
                        <input type="text" id="goods-weight" class="form-control weight" name="Goods[weight][]" value="1">

                        <div class="help-block"></div>
                    </div></div>
                <div class="col-sm-1"><div class="form-group field-goods-single_price required">
                        <label class="control-label" for="goods-single_price">单价</label>
                        <input type="text" id="goods-single_price" class="form-control single_price" name="Goods[single_price][]">

                        <div class="help-block"></div>
                    </div></div>
                <div class="col-sm-1"><div class="form-group field-goods-final_price required">
                        <label class="control-label" for="goods-final_price">结算价格</label>
                        <input type="text" id="goods-final_price" class="form-control final_price" name="Goods[final_price][]">

                        <div class="help-block"></div>
                    </div></div>
                <div class="col-sm-1">
                    <a class="btn btn-success del_goods" href="javascript:void(0)" style="margin-top:38%;">删除</a>
                </div>
            </div>
        </div>
    </script>
</div>

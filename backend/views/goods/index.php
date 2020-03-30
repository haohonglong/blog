<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '商品列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '添加商品'), ['create'], ['class' => 'btn btn-success']) ?>

    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user.username',
            [
                'label'=>'超市名称',
                'attribute' => 'shop_name',
                'value' => 'shop.name',
            ],
            'name',
            'number',
            'weight',
            'single_price',
            'final_price',
            'create_by',
            'update_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'caption'=>"当前可见页面实际消费总计 : {$curTotalPrice} <br/> 实际消费总计 : {$totalPrice}"
    ]); ?>
    <?php Pjax::end(); ?>
</div>

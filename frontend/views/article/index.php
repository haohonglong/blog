<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 31/03/2018
 * Time: 12:10 PM
 */
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row MB10">
    <div class="col-md-7">
        <?php $form = ActiveForm::begin(['action'=>'/article/index']);?>
        <div class="input-group" style="width:50%;">
                <input type="text" name="keyword" class="form-control" placeholder="输入标题关键字">
                <span class="input-group-btn">
                <button class="btn btn-default" type="submit">搜索</button>
          </span>
        </div><!-- /input-group -->
        <?php ActiveForm::end();?>
    </div>
    <div class="col-md-5 text-right">
    </div>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions'=>['class'=>'table table-striped table-bordered table-hover'],
    'columns' => [
       [
            'label'=>'文章标题',
           'format' => 'html',
            'value' => function ($data,$key) {
                return Html::a($data->title, Url::to(['article/view','id'=>$key]));
            },
        ],






    ],
    
]); ?>

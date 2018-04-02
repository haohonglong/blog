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
        <a href="<?=Url::to(['/article/add'])?>" class="btn btn-primary btn-sm active" role="button">添加文章</a>
    </div>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
       'id',
        [
            'label'=>'文章标题',
            'value' => function ($data) {
                return $data->title;
            },
        ],
        [
            'label'=>'创建时间',
            'value' => function ($data) {
                return $data->cdate;
            },
        ],
        [
            'label'=>'修改时间',
            'value' => function ($data) {
                return $data->udate;
            },
        ],

        [
            "class" => "yii\grid\ActionColumn",
            "template" => "{view}  |   {edit} |  {remove}",
            "header" => "操作",
            "buttons" => [
                "view" => function ($url) {
                    return Html::a("查看", $url );
                },
                "edit" => function ($url) {
                    return Html::a("修改", $url );
                },
                "remove" => function ($url) {
                    return Html::a("删除", $url );
                },


            ],
        ],



    ],
    
]); ?>


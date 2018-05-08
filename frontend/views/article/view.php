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

$this->title = '修改文章';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">
    <?php $this->beginBlock('js'); ?>
    LAM.run([jQuery],function ($) {
        'use strict';
        var System = this;

        function init() {
            new Vue({
                el: '#address_menu',
                data: {
                    menu:[]
                },
                methods: {
                    content: function (id) {

                    }
                },
                created:function () {

                }


            });
        }


    });

    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js'], \yii\web\View::POS_END); //将编写的js代码注册到页面底部  ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?=$article['title']?></h3>
            </div>
            <div class="panel-body">
                <p class="text-right">发表于: <?=date('Y-m-d',strtotime($article['cdate']))?></p>
                <?=Html::decode($article['content'])?>
            </div>
        </div>

    </div>
</div>
<?php foreach ($posts as $item):?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">回复<?=$item['id'];?></h3>
    </div>
    <div class="panel-body">
        <?=$item['content'];?>
        <p>日期：<?=$item['date'];?> | </p>
        <?php if(isset($item['reply']) && is_array($item['reply'])):?>
        <?php foreach ($item['reply'] as $reply):?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">回复<?=$reply['id'];?></h3>
                </div>
                <div class="panel-body">
                    <?=$reply['content'];?>
                    <p>日期：<?=$reply['date'];?> | </p>
                </div>
            </div>
        <?php endforeach;?>
        <?php endif;?>
    </div>
</div>
<?php endforeach;?>



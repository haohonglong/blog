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

$this->title = '修改文章';
$this->params['breadcrumbs'][] = $this->title;
$posts = json_encode($posts);
$content = Html::decode($article["content"]);
?>
<script type="text/javascript">
    <?php $this->beginBlock('js'); ?>
    LAM.run([jQuery],function ($) {
        'use strict';
        var System = this;

        new Vue({
            el: '#article',
            data: {
                title:"<?=$article['title']?>",
                date:"<?=date('Y-m-d',strtotime($article['cdate']))?>",
                posts:<?=$posts?>
            },
            methods: {

            },
            created:function () {

            }


        });
        $(function(){



        });



    });

    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js'], \yii\web\View::POS_END); //将编写的js代码注册到页面底部  ?>


<div id="article">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">{{title}}</h3>
                </div>
                <div class="panel-body">
                    <p class="text-right">发表于: {{date}}</p>
                    <?=$content?>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
            ]) ?>
            <input type="hidden" name="PostsForm[article_id]" value="<?=$article_id?>">
            <?= $form->field($model, 'content')->textarea(['style'=>'height:150px;']) ?>

            <div class="form-group text-right">
                <button class="btn btn-primary" type="submit">提交评论</button>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
    <div class="panel panel-default" v-if="posts.length" v-for="item in posts">
        <div class="panel-heading">
            <h3 class="panel-title">回复{{item.id}}</h3>
        </div>
        <div class="panel-body">
            {{item.content}}
            <p>日期：{{item.date}} | </p>
            <div class="panel panel-default" v-for="reply in item.reply">
                <div class="panel-heading">
                    <h3 class="panel-title">回复{{reply.id}}</h3>
                </div>
                <div class="panel-body">
                    {{reply.content}}
                    <p>日期：{{reply.date}} | </p>
                </div>
            </div>
        </div>
    </div>
</div>





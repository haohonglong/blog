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




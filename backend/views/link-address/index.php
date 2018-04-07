<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 31/03/2018
 * Time: 12:10 PM
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '网页地址';
$this->params['breadcrumbs'][] = $this->title;


?>

<script type="text/javascript">
    <?php $this->beginBlock('js'); ?>
    LAM.run([jQuery],function ($) {
        'use strict';
        var System = this;
        var menu=[],list=[];
        new Vue({
            el: '#address_menu',
            data: {
                menu:menu
            },
            methods: {
                content: function (id) {
                    $.get('/link-address/index',{
                        'sorts_id':id
                    },function(D){
                        if(D.status){
                            list = D.data;


                        }
                    },'json');
                }
            },
            created:function () {
                var v = this;

                $.get('/link-address/index',function(D){
                    if(D.status){
                        v.menu = D.data;

                    }
                },'json');
            }


        });

        // new Vue({
        //     el:'#address_content'
        // });
        //
        // Vue.component('contents-temp', {
        //     data: function(){
        //         return {
        //             list:list
        //         };
        //     },
        //     template: $('#contents-temp').html()
        // });


        // Vue.component('contents-temp', {
        //     data: function () {
        //         return {
        //             count: 0,
        //             list:list
        //         }
        //     },
        //     template: $('#contents-temp').html()
        // });
        //
        //
        // new Vue({ el: '#address_content' })









    });

    <?php $this->endBlock(); ?>
</script>

<?php $this->registerJs($this->blocks['js'], \yii\web\View::POS_END); //将编写的js代码注册到页面底部  ?>
<div class="row ">
    <div class="col-md-7">

    </div>
    <div class="col-md-5 text-right">
        <a href="<?=Url::to(['/link-address/add'])?>" class="btn btn-primary btn-sm active" role="button">添加地址</a>
    </div>
</div>


<div class="row">
    <div class="col-md-3">
        <div class="list-group" id="address_menu">
            <template v-for="item in menu">
                <a href="javascript:void(0)" @click="content(item.id)" class="list-group-item"  :data-id="item.id" >{{item.name}}</a>
            </template>
        </div>
    </div>
    <div class="col-md-9" id="address_content">
            <contents-temp></contents-temp>
    </div>
</div>


<script type="text/html" id="contents-temp">
    <button v-on:click="count++">You clicked me {{ count }} times.</button>
</script>
<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 31/03/2018
 * Time: 12:10 PM
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\db\Query;

$this->title = '网页地址';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .mCustomScrollbar{height: 500px;overflow: auto;}
    .mCSB_scrollTools .mCSB_draggerContainer{left:-43px;}

</style>
<script type="text/javascript">
    <?php $this->beginBlock('js'); ?>
    LAM.run([jQuery],function ($) {
        'use strict';
        var System = this;




        var cache = new System.Cache('menu_11');
        $(function () {

            $(document).on("click","#address_menu a",function () {
                $("#address_menu a").removeAttr('style'," ");
                $(this).css({
                    'background-color':'#f5f5f5'
                });

            });
            
        });

        window.vue =new Vue({
                el: '#container',
                data: {
                    menu:[],
                    title:'',
                    sortid:"",
                    contents: []
                },
                methods: {
                    content: function (id,title,index) {
                        this.sortid = id;
                        this.title = title;
                        var dom = this.$refs.menu[index];
                        $("#mCSB_1_container").css("top", -dom.offsetTop);
                        cache.find('m_id',id,function (index,id) {
                            var _this = this;
                            if(-1 === index){
                                var wait = layer.load();
                                $.get('/link-address/index',{
                                    'sorts_id':id
                                },function(D){
                                    layer.close(wait);
                                    if(D.status){
                                        vue.contents = D.data;
                                        _this.add({list: D.data});
                                    }else{
                                        vue.contents = [];
                                    }

                                },'json');
                            }else{
                                vue.contents = this.get(index).list;
                            }

                        });

                    },
                    remove: function(id) {
                        if(confirm("are you sure delete this?")){
                            $.get('/link-address/remove',{'id':id},function(D){
                                if(D.status){
                                    vue.$router.go(0);
                                }else{
                                    alert('error');
                                }
                            },'json');
                        }
                    }
                },
                created:function () {

                    $.get('/link-address/index',function(D){
                        $('.mCustomScrollbar').mCustomScrollbar();
                        if(D.status){
                            vue.menu = D.data;

                        }
                    },'json');
                },
                mounted:function () {
                    var dom,$menu;
                    System.listen(function(){
                        $menu = $("#address_menu");
                        dom = $menu.find("a[data-id='<?=$sorts_id?>']")[0];
                        if(dom){
                            dom.click();
                            $("#mCSB_1_container").css("top", -dom.offsetTop);
                            return true;

                        }

                    },1);
                }



            });


    });

    <?php $this->endBlock(); ?>
</script>

<?php $this->registerJs($this->blocks['js'], \yii\web\View::POS_END); //将编写的js代码注册到页面底部  ?>

<style type="text/css">
    #address_menu{height:30em;overflow: auto;}
    .btn.btn-info a{color:#fff;}
</style>
<div id="container">
    <div class="row">
        <div class="col-md-7">

            <h3>{{title}}</h3>
        </div>
        <div class="col-md-5 text-right">
            <a :href="'/link-address/edit?sortid='+sortid" class="btn btn-primary btn-sm active" role="button">添加地址</a>
        </div>
    </div>


    <div class="row">
        <div class="col-md-3 mCustomScrollbar" id="address_menu" data-mcs-theme="dark">
            <div class="list-group">
                <div v-if="menu.length">
                    <template v-for="(item, index) in menu">
                        <a href="javascript:void(0);" @click="content(item.id,item.name,index)" ref="menu" class="list-group-item"  :data-id="item.id" >{{item.name}}</a>
                    </template>
                </div>
                <div v-else>
                    没有数据
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <button style="margin-right: 10px;" class="btn btn-info MB10" v-for="item in contents">
                <a :href="item.url" target="_blank">{{ item.name }}</a>
                <a :href="'/link-address/edit?id='+ item.id +'&sortid='+ sortid" target="_blank">修改</a>
                <a @click="remove(item.id)" href="javascript:void(0);" >删除</a>
            </button>
        </div>
    </div>
</div>






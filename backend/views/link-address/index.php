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
    LAM.run(function () {
        'use strict';
        var System = this;
        System
            .import([
                '/base/Cache.class',
                '/base/Storage.class'
            ], System.classPath);


        var temp = new System.Template();



        var cache = new System.Cache('menu_11');
        $(function () {

            temp.parse($('#address_content_tpl').html());
            $(document).on("click","#address_menu a",function () {
                $("#address_menu a").removeAttr('style'," ");
                $(this).css({
                    'background-color':'#f5f5f5'
                });

            });

            $(document).on("click","#address_content a[ref=del]",function () {
                if(confirm("are you sure delete this?")){
                    var id = $(this).data().id;
                    var $button = $(this).parent('button');
                    $.get('/link-address/remove',{'id':id},function(D){
                        if(D.status){
                            $button.remove();
                        }else{
                            alert('error');
                        }
                    },'json');
                }


            });

            var vue =new Vue({
                el: '#container',
                data: {
                    menu:[],
                    title:'',
                    sortid:""
                },
                methods: {
                    content: function (id,title,index) {
                        this.sortid = id;
                        this.title = title;
                        var dom = this.$refs.menu[index];
                        $("#mCSB_1_container").css("top", -dom.offsetTop);
                        cache.find('m_id',id,function (index,id) {
                            var _this = this;
                            var list=null;
                            if(-1 === index){
                                var wait = layer.load();
                                $.get('/link-address/index',{
                                    'sorts_id':id
                                },function(D){
                                    layer.close(wait);
                                    if(D.status){
                                        list = D.data;
                                        _this.add({list:list});
                                    }else{
                                        list = "没有数据";
                                    }
                                },'json');
                            }else{
                                list = this.get(index).list;
                            }
                            System.listen(function(){
                                if(list){
                                    if(System.isString(list)){
                                        $('#address_content').html(list);
                                    }else{

                                        $('#address_content').html(System.Template.getBlock('content',{list:list,sortid:id}));
                                    }

                                    return true;
                                }
                            },1);

                        });

                    }
                },
                created:function () {
                    var v = this;

                    $.get('/link-address/index',function(D){
                        $('.mCustomScrollbar').mCustomScrollbar();
                        if(D.status){
                            v.menu = D.data;

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
            <div id="address_content"></div>
        </div>
    </div>
</div>


<script type="text/html" id="address_content_tpl">
    <#Block:begin id="content" data="{'list':null}">
    <%LAM.each(list,function(){%>
    <button class="btn btn-info MB10" data-id="<%=this['id']%>">
        <a href="<%=this['url']%>" target="_blank"><%=this['name']%></a>
        <a href="/link-address/edit?id=<%=this['id']%>&sortid=<%=sortid%>" target="_blank">修改</a>
        <a href="javascript:void(0);" ref="del" data-id="<%=this['id']%>" >删除</a>
    </button>
    <% });%>
    <#Block:end>

</script>




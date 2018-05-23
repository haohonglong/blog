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
<script type="text/javascript">

</script>
<script type="text/javascript">
    <?php $this->beginBlock('js'); ?>
    LAM.run(function () {
        'use strict';
        var System = this;
        System.import([
            '/base/Cache.class',
            '/base/Storage.class'
        ], System.classPath);
    });
    LAM.wait([jQuery],function ($) {
        'use strict';
        var System = this;

        var cache = new System.Cache('menu_11');

        new Vue({
            el: '#container',
            data: {
                menu:[],
                title:''
            },
            methods: {
                content: function (id,title) {
                    this.title = title;
                    cache.find('m_id',id,function (index,id) {
                        var _this = this;
                        var list=null;
                        if(-1 === index){
                            $.get('/link-address/index',{
                                'sorts_id':id
                            },function(D){
                                if(D.status){
                                    list = D.data;
                                    _this.add({list:list});
                                }
                            },'json');
                        }else{
                            list = this.get(index).list;
                        }
                        System.listen(function(){
                            if(list){
                                $('#address_content').html(template('address_content_tpl',{list:list}));
                                return true;
                            }
                        },1);

                    });

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

    },100);

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
            <a href="<?=Url::to(['/link-address/add'])?>" class="btn btn-primary btn-sm active" role="button">添加地址</a>
        </div>
    </div>


    <div class="row">
        <div class="col-md-3" id="address_menu">
            <div class="list-group">
                <div v-if="menu.length">
                    <template v-for="item in menu">
                        <a href="javascript:void(0)" @click="content(item.id,item.name)" class="list-group-item"  :data-id="item.id" >{{item.name}}</a>
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
    <% for(var i=0,len =list.length;i < len; i++){%>
    <button class="btn btn-info MB10" data-id="<%=list[i]['id']%>">
        <a href="<%=list[i]['url']%>" target="_blank"><%=list[i]['name']%></a>
        <a href="/link-address/edit?id=<%=list[i]['id']%>" target="_blank">修改</a>
    </button>
    <% }%>
    </template>
</script>


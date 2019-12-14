<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 31/03/2018
 * Time: 12:10 PM
 */

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = '抓取模版';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">
    LAM.run(function () {
        'use strict';
        var System = this;
        var tag = System.Html.tag;
        var tpl = tag('div',{'class':'row','style':'margin-top:10px'},
                    [
                        tag('div',{'class':'col-lg-5'},
                            tag('div',{'class':'input-group'},
                                tag(true,'input',{'type':'text','class':'form-control','name':'search[]'}))
                        ),
                        tag('div',{'class':'col-lg-2'},'--'),
                        tag('div',{'class':'col-lg-5'},
                            tag('div',{'class':'input-group'},
                                tag(true,'input',{'type':'text','class':'form-control','name':'replace[]'}))
                        )
                    ]);

        $(function () {
            $('#replace_button').on('click',function () {
                $('#replaces_content').append(tpl);
            });
        });
    });
</script>
<div class="row MB20">
    <div class="col-md-7">
        <?php $form = ActiveForm::begin();?>
        <div class="input-group" style="width:100%;">
            <input type="text" name="root" class="form-control" placeholder="网站根网站">
        </div>
        <div class="input-group" style="width:100%;margin-top:20px;">
            <input type="text" name="url" class="form-control" placeholder="网站地址">
        </div>
        <div class="input-group" style="width:100%;margin-top:20px;">
            <input type="text" name="path" class="form-control" placeholder="保存路径">
        </div>
        <div id="replaces_content"></div>

        <div class="input-group" style="text-align: right;margin-top:20px;">
                <button class="btn btn-default" type="submit" style="margin-right: 50px">抓取</button>
                <button class="btn btn-default" type="button" id="replace_button">添加替换</button>
        </div>
        <?php ActiveForm::end();?>
    </div>

</div>



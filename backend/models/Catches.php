<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/11/2019
 * Time: 3:46 PM
 */

namespace backend\models;


class Catches
{

    public $ori_url = "";
    public $local_url = "";
    public $abs_path = "";
    public $rel_path = "";
    public $content = "";
    public $name = "";
    public $csses = [];
    public $jses = [];
    public function __construct($ori_url,$local_url)
    {
        $this->ori_url = $ori_url;

        $this->local_url = $local_url;
        $this->content = $this->file_get($ori_url);


    }
    public function assets($path,$attrs)
    {

//然后可以把页面源码或者HTML片段传给QueryList
        $data = QueryList::html($this->content)->rules([  //设置采集规则
            // 采集所有a标签的href属性
            'link' => $attrs
        ])->query()->getData();
//打印结果
        print_r($data->all());
    }
    public function css()
    {
        $this->assets('',['link','href']);
    }
    public function js()
    {}
    public function image()
    {

    }
    public function init()
    {}
    public function run()
    {

    }
    public function file_get($url)
    {
        return file_get_contents($url);
    }
    public function file_put($url,$content)
    {
        file_put_contents($url,$content);
    }

}
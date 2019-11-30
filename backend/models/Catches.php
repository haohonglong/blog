<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/11/2019
 * Time: 3:46 PM
 */

namespace backend\models;

use yii;
use QL\QueryList;


class Catches
{

    public $local_url = "";
    public $path = "";
    public $abs_path = "";
    public $rel_path = "./";
    private $content = "";
    public $name = "";
    public $csses = [];
    public $jses = [];
    public function __construct($ori_url,$local_url)
    {
        $local_url = Yii::getAlias('@sites').'/'.$local_url;
        $this->local_url = $local_url;
        $arr = pathinfo($local_url);
        $this->path = $arr['dirname'];
        $this->name = $arr['basename'];
        $this->rel_path = str_replace(\Yii::getAlias('@backend/web'),'',$this->path);
        $this->content = $this->file_get($ori_url);
        $this->content = trim($this->content);


    }
    public function assets($folder,$attrs)
    {

        $data = QueryList::html($this->content)->rules([  //设置采集规则
            // 采集所有a标签的href属性
            'link' => $attrs
        ])->query()->getData()->all();

        foreach ($data as $v){
            $src = $v['link'];
            if(isset($src) && !empty($src)){
                $name = pathinfo($src)['basename'];
                $content = $this->file_get($src);
                $this->replace($src,$this->rel_path.'/'.$folder.'/'.$name);
                $this->file_put($this->path.'/'.$folder,$name,$content);
                $path = $this->path.'/'.$folder.'/'.$name;
                switch ($folder){
                    case 'css':
                        $this->csses[] = $path;
                        break;
                    case 'js':
                        $this->jses[] = $path;
                        break;

                }
            }
        }
    }
    public function css()
    {
        $this->assets('css',['link','href']);
        return $this;
    }
    public function js()
    {
        $this->assets('js',['script','src']);
        return $this;
    }
    public function image()
    {
        $this->assets('images',['img','src']);
        return $this;
    }

    public function replace($search, $replace)
    {
        $this->content = str_replace($search, $replace, $this->content);
        return $this;
    }
    public function init()
    {

    }
    public function run()
    {
        $this->css()->js()->image();
        return $this;

    }
    public function file_get($url)
    {
        return @file_get_contents($url);
    }
    public function file_put($path,$name,$content)
    {
        $this->create($path);
        @file_put_contents($path.'/'.$name,$content);
    }
    private function create($path)
    {
        if(!is_dir($path)){
            $res=mkdir(iconv("UTF-8", "GBK", $path),0777,true);
            if (!$res){
                echo "目录 $path 创建失败";
                exit;
            }
        }
    }

    public function getContent()
    {
        return $this->content;
    }

    public function saved()
    {
        $this->file_put($this->path,$this->name,trim($this->content));
    }

}
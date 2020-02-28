<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 08/01/2020
 * Time: 3:38 PM
 */

namespace common\models;


class Tree
{
    static public function getTree($array,&$tree=[]){
        $items = [];
        foreach($array as $value){
            $items[$value['id']] = $value;
        }
        foreach($items as $key => $value){
            //如果pid这个节点存在
            if(isset($items[$value['parent_id']])){
                //把当前的$value放到pid节点的son中 注意 这里传递的是引用 为什么呢？
                $items[$value['parent_id']]['childs'][] = &$items[$key];
            }else{
                $tree[] = &$items[$key];
            }
        }
    }

}
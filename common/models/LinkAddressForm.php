<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 03/04/2018
 * Time: 7:13 PM
 */

namespace common\models;


// use yii\base\Model;

class LinkAddressForm extends LinkAddress
{
    public $sorts_id,$name,$info,$url,$model;
    
    
    public function save()
    {
        if($this->validate()){
            $inkAddress = $this->model;
            $inkAddress->sorts_id = isset($this->sorts_id) ? $this->sorts_id : 0;
            $inkAddress->name = $this->name;
            $inkAddress->info = $this->info;
            $inkAddress->url = $this->url;
            $inkAddress->date = date('Y-m-d H:i:s');
            if(!$inkAddress->save()){
                $this->addError($inkAddress->getErrors());
                return false;
            }
            return true;
        }

        return false;

    }


}
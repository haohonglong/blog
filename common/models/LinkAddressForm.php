<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 03/04/2018
 * Time: 7:13 PM
 */

namespace common\models;


use yii\base\Model;

class LinkAddressForm extends Model
{
    public $sorts_id,$name,$info,$url,$model;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'info', 'sorts_id'], 'required'],
            [['sorts_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 1024],
            [['info'], 'string'],

        ];
    }
    
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



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '名称',
            'url' => 'Url',
            'info' => '表述内容',
            'date' => '日期',
            'sorts_id' => '类别',
        ];
    }
}
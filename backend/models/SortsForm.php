<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 30/03/2018
 * Time: 8:19 PM
 */

namespace backend\models;


use yii\base\Model;

class SortsForm extends Model
{

    public $id,$pid,$name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','pid'], 'required'],
            [['name'], 'string', 'max' => 11],
        ];
    }

    public function save()
    {
        if($this->validate()){
            $sorts = new Sorts();
            $sorts->pid = $this->pid;
            $sorts->name = $this->name;
            if(!$sorts->save()){
                $this->addError($sorts->getErrors());
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
            'id' => 'ID',
            'pid' => 'pid',
            'name' => '名称',
        ];
    }
}
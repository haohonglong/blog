<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 30/03/2018
 * Time: 8:19 PM
 */

namespace common\models;


use yii\base\Model;

class SortsForm extends Model
{

    public $id,$name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 11],
        ];
    }

    public function save()
    {
        if($this->validate()){
            $sorts = new Sorts();
            $sorts->name = $this->name;
            if(!$sorts->save()){
                $this->addError($sorts->getErrors());
            }
            return true;
        }

        return false;

    }

    public function edit()
    {
        if($this->validate()){
            $sorts = Sorts::find()->where(['id'=>$this->id])->limit(1)->one();
            $sorts->name = $this->name;
            if(!$sorts->save()){
                $this->addError($sorts->getErrors());
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
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 24/04/2018
 * Time: 12:49 PM
 */

namespace common\models;

use yii;
use yii\base\Model;
use yii\helpers\Html;

class VideoForm extends Model
{
    public $source,$title;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'source'], 'required'],
            [['source'], 'string'],
            [['title'], 'string', 'max' => 500],
        ];
    }
    public function save(){
        if($this->validate()){
            $video = new Video();
            $video->title = $this->title;
            $video->source = Html::encode($this->source);
            $video->date = date('Y-m-d H:i:s');
            if(!$video->save()){
                $this->addError($video->getErrors());
                return false;
            }
            return true;

        }
    }

    public function edit($video)
    {
        if($this->validate()){
            if(!$video){return false;}
            $video->title = $this->title;
            $video->source = Html::encode($this->source);
            $video->date = date('Y-m-d H:i:s');
            if(!$video->save()){
                $this->addError($video->getErrors());
                return false;
            }
            return true;
        }

        return false;

    }
    public function remove($id)
    {
        $video = Video::find()->where(['id'=>$id])->limit(1)->one();
        if(!$video) {return false;}
        if(!$video->delete()){
            $this->addError($video->getErrors());
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'source' => 'Source',
        ];
    }
}
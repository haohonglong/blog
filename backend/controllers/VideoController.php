<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 24/04/2018
 * Time: 12:57 PM
 */

namespace backend\controllers;

use yii;
use yii\db\Query;
use common\models\Video;
use common\models\VideoForm;
use yii\web\Controller;

class VideoController extends Controller
{
    public function actionIndex()
    {
        $query = (new Query())->from('video');
        $list = $query->all();
        $var = [
            'list'=>$list
        ];
        return $this->render('index',$var);
    }
    /**
     * @return string|yii\web\Response
     */
    public function actionAdd()
    {
        $model = new VideoForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack();
        } else {
            return $this->render('add', [
                'model' => $model,
            ]);
        }
    }

    public function actionEdit($id)
    {

        $model = new VideoForm();
        $video = Video::getById($id);
        if ($model->load(Yii::$app->request->post()) && $model->edit($video)) {
            return $this->goBack();
        } else {
            $model->title  = $video->title;
            $model->date   = $video->date;
            $model->source = Html::decode($video->source);
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionRemove()
    {
        $request = yii::$app->request;
        if($request->isGet){
            $id = $request->get('id');
            $video = new VideoForm();
            $video->remove($id);
            return $this->redirect(['video/index']);
        }


    }
}
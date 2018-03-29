<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/03/2018
 * Time: 6:22 PM
 */

namespace backend\controllers;
use common\models\PostsForm;
use yii;

class PostsController extends BaseController
{
    public function actionRemove()
    {
        $request = yii::$app->request;
        if($request->isGet){
            $id = $request->get('id');
            $posts = new PostsForm();
            $posts->remove($id);
        }


    }
}
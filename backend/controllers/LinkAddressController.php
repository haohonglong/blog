<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 03/04/2018
 * Time: 7:11 PM
 */

namespace backend\controllers;

use yii;
use common\models\LinkAddress;
use common\models\LinkAddressForm;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class LinkAddressController extends BaseController
{
    public function actionIndex()
    {
        $keyword = trim(Yii::$app->request->get('keyword'));
        if(Yii::$app->request->isAjax){

            $sorts_id = Yii::$app->request->get('sorts_id');

            if(isset($sorts_id)){

                $query = (new Query())->from('linkaddress');
                $content = $query->where(['sorts_id'=>$sorts_id])->all();
                if($content){
                    $var = [
                        'status'=>1,
                        'data'=>$content,
                    ];
                }else{
                    $var = [
                        'status'=>0,
                        'msg'=>'获取数据失败',
                    ];
                }
                echo json_encode($var);
                exit;
            }else{
                $query = (new Query())->from('sorts');
                $content = $query->all();
                if($content){
                    $var = [
                        'status'=>1,
                        'data'=>$content,
                    ];
                }else{
                    $var = [
                        'status'=>0,
                        'msg'=>'获取数据失败',
                    ];
                }
                echo json_encode($var);
                exit;
            }

        }else{
            return $this->render('index');
        }

    }

    public function actionEdit($id=null)
    {

        $linkAddress = LinkAddress::findById($id);
        if(!$linkAddress){
            $linkAddress = new LinkAddress();
        }
        $model = new LinkAddressForm();
        if ($model->load(Yii::$app->request->post(),'LinkAddress')) {
            $model->model = $linkAddress;
            if($model->save()){
                return $this->redirect(['/link-address/index']);

            }
        } else {
            $sort = (new Query())->from('sorts')->select('id,name')->all();
            $sorts = ArrayHelper::map($sort,'id','name');
            return $this->render('edit', [
                'model' => $linkAddress,
                'sorts' => $sorts,
            ]);
        }
    }

    /**
     * 批量修改地址的sorts_id
     */
    public function actionBatchMoveSort(){
        $request = yii::$app->request;
        $ids = $request->post('ids');
        $sorts_id = $request->post('sorts_id');
        $r = LinkAddress::updateAll(['sorts_id'=>$sorts_id],['in','sorts_id',explode(',',$ids)]);
        if($request->isAjax){
            if($r){
                $var = [
                    'status'=>1,
                ];
            }else{
                $var = [
                    'status'=>0,
                ];
            }
            echo json_encode($var);

        }else{

        }
    }
    public function actionRemove(){
        $request = yii::$app->request;
        if($request->isAjax){
            if(LinkAddress::removeById($request->post('id'))){
                $var = [
                    'status'=>1,
                ];
            }else{
                $var = [
                    'status'=>0,
                ];
            }
            echo json_encode($var);
            exit;
        }

    }
}
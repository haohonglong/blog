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
//            $query = (new Query())->from('linkaddress lk');
//            $query->select('lk.id id,lk.name name,lk.url url,lk.info info,lk.date date');
//            $query->addSelect('s.id sid,s.name title');
//            $query->innerJoin('sorts s','lk.sorts_id = s.id');
//            if(!empty($keyword)){
//                $query->andWhere(['like','name',$keyword]);
//            }
//
//            $list = $query->all();
//            $lists = [];
//            foreach ($list as $item){
//                if(!isset($lists[$item['sid']])){
//                    $lists[$item['sid']] = [
//                        'sid'=>$item['sid'],
//                        'title'=>$item['title'],
//                        'child'=>[],
//                    ];
//                }
//                $lists[$item['sid']]['child'][] = [
//                    'id'=>$item['id'],
//                    'name'=>$item['name'],
//                    'info'=>$item['info'],
//                    'date'=>$item['date'],
//                ];
//
//            }
//            $lists = array_values($lists);
//            $var = [
//                '$list'=>$lists,
//            ];
//        print_r($lists);exit;
            return $this->render('index');
        }

    }
    public function actionAdd()
    {
        $model = new LinkAddressForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/link-address/index']);
        } else {
            $sort = (new Query())->from('sorts')->select('id,name')->all();
            $sorts = ArrayHelper::map($sort,'id','name');
            return $this->render('add', [
                'model' => $model,
                'sorts' => $sorts,
            ]);
        }
    }
    public function actionEdit($id)
    {
        $model = new LinkAddressForm();
        $linkAddress = LinkAddress::findById($id);
        if ($model->load(Yii::$app->request->post()) && $model->edit($linkAddress)) {
            return $this->redirect(['/link-address/index']);
        } else {
            $model->name = $linkAddress->name;
            $model->url = $linkAddress->url;
            $model->info = $linkAddress->info;
            $model->sorts_id = $linkAddress->sorts_id;
            $sort = (new Query())->from('sorts')->select('id,name')->all();
            $sorts = ArrayHelper::map($sort,'id','name');
            return $this->render('edit', [
                'model' => $model,
                'sorts' => $sorts,
            ]);
        }
    }
    public function actionRemove(){}
}
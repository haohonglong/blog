<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 03/04/2018
 * Time: 7:11 PM
 */

namespace backend\controllers;

use yii;
use common\models\{LinkAddress,LinkAddressForm};
use yii\db\Query;
use yii\helpers\ArrayHelper;

class LinkAddressController extends BaseController
{

    private function shape()
    {
        $values = array(
            40,50,
            20,240,
            60,60,
            240,20,
            50,40,
            10,10,
        );                                //设置点坐标，绘制六边形用一个数组把六个点的坐标储存起来
        //创建图像      是一个变长为250的正方形      此处用到函数ImageCreateTrueColor()
        $image = imagecreatetruecolor(250,250);

        //设定颜色         以后要用到
        $bgcolor = imagecolorallocate($image,200,200,200);
        $blue = imagecolorallocate($image,0,0,255);

        //画一个多边形       用到函数ImageFilledPolygon()   相信下面括号里的参数一看就懂吧，记住我们要画六边形
        imagefilledpolygon($image,$values,6,$blue);

        //输出图像
        header("Content-type:image/png");   //此函数用来发送页面的http标题^_^ 小菜我也只是了解
        imagepng($image);                   //将图像以png的格式发送到浏览器
        imagedestroy($image);
    }
    public function actionIndex()
    {

        $keyword = trim(Yii::$app->request->get('keyword'));

        if(Yii::$app->request->isAjax){

            $sorts_id = Yii::$app->request->get('sorts_id');


            if(isset($sorts_id)){
                $cookies = Yii::$app->response->cookies;
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'sortsId',
                    'value' => $sorts_id,
                ]));
                Yii::$app->response->send();
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
            $cookies = Yii::$app->request->cookies;
            return $this->render('index',[
                'sorts_id'=>$cookies->getValue('sortsId', '1'),
            ]);
        }

    }

    public function actionEdit($id=null)
    {

        $sortid = yii::$app->request->get('sortid');
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
                'sortid' => $sortid,
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
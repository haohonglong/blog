<?php

namespace backend\controllers;

use app\models\Bills;
use backend\models\Shop;
use Yii;
use backend\models\Goods;
use backend\models\GoodsSearch;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShopListController implements the CRUD actions for ShopList model.
 */
class GoodsController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ShopList models.
     * @return mixed
     */
    public function actionIndex()
    {

//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        $data = Goods::find()->select([
//            'id',
//            'name'
//        ])->asArray()->all();
////        echo json_encode($data,JSON_UNESCAPED_UNICODE);
//        return $data;
//        exit;
        $searchModel = new GoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModel->create_by = !empty($searchModel->create_by) ? date('Y-m-d',$searchModel->create_by) : '';
        $searchModel->update_by = !empty($searchModel->update_by) ? date('Y-m-d',$searchModel->update_by) : '';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalPrice' => Goods::totalPrices(),
            'curTotalPrice' => GoodsSearch::currentTotalPrices($dataProvider),
        ]);
    }

    /**
     * Displays a single ShopList model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->create_by = date('Y-m-d',$model->create_by);
        $model->update_by = date('Y-m-d',$model->update_by);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @author: lhh
     * 创建日期：2020-04-15
     * 修改日期：2020-04-15
     * 名称： addGoods
     * 功能：添加一个或多个商品
     * 说明：
     * 注意：
     * @param $model        商品模型
     * @param $bill_id      账单号
     * @return float|int    商品价格总数
     * @throws \Exception
     * @throws \Throwable
     */
    private function addGoods($model,$bill_id)
    {
        $total = 0;
        if (is_array($model->name)) {
            $data = [];
            foreach ($model->name as $i => $item) {
                $data[$i]['uid'] = $model->uid;
                $data[$i]['shop_id'] = $model->shop_id;
                $data[$i]['bill_id'] = $bill_id;
                $data[$i]['create_by'] = $model->create_by;
                $data[$i]['update_by'] = $model->update_by;
                $data[$i]['name'] = $model->name[$i];
                $data[$i]['number'] = $model->number[$i];
                $data[$i]['weight'] = $model->weight[$i];
                $data[$i]['single_price'] = $model->single_price[$i];
                $data[$i]['final_price'] = $model->final_price[$i];
                $total += (double)$data[$i]['final_price'];
            }
            Yii::$app->db->transaction(function ($db) use ($data) {
                $db->createCommand()->batchInsert('goods', [
                    'uid',
                    'shop_id',
                    'bill_id',
                    'create_by',
                    'update_by',
                    'name',
                    'number',
                    'weight',
                    'single_price',
                    'final_price'
                ], $data)->execute();

            });
        } else {
            $total = (double)$model->final_price;
            $model->save();
        }
        return $total;
    }



    /**
     * Creates a new ShopList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goods();
        $bills = new Bills();

        if($bill_id = Yii::$app->request->get('bill_id',null)){
            $bills = Bills::find()->where(['bill_id'=>$bill_id])->limit(1)->one();
            if(isset($bills)){
                $model->shop_id = $bills->shop_id;
            }else {
                throw new \Exception("bill_id 不存在");
            }
        }



        if ($bills->load(Yii::$app->request->post())) {
            if ($model->load(Yii::$app->request->post())) {

                $model->uid = Yii::$app->user->identity->getId();
                $model->create_by = strtotime($model->create_by);
                $model->update_by = $model->create_by;
                Yii::$app->db->createCommand('LOCK TABLES '.Goods::tableName().' WRITE,'.Bills::tableName().' WRITE')->execute();
                if(isset($bill_id)) {//根据账单号继续添加商品
                    if($bill_id != $bills->bill_id){
                        Yii::$app->db->createCommand('UNLOCK TABLES')->execute();
                        throw new \Exception("提交的bill_id 与数据库不符合");
                    }else{
                        $total = $this->addGoods($model,$bills->bill_id);
                        $bills->price = (double)$bills->price + (double)$total;
                        $bills->update_at = $model->create_by;
                        $bills->save();
                        Yii::$app->db->createCommand('UNLOCK TABLES')->execute();
                        return $this->redirect('index');
                        exit;
                    }
                }else {
                    $bills->shop_id   = $model->shop_id;
                    $bills->create_at = $model->create_by;
                    $bills->update_at = $model->update_by;
                    $bills->price = 0;
                    if($bills->validate()){
                        $total = $this->addGoods($model,$bills->bill_id);
                        $bills->price = (double)$total - (double)$bills->discount;
                        $bills->save();
                        Yii::$app->db->createCommand('UNLOCK TABLES')->execute();
                        return $this->redirect('index');
                        exit;
                    }
                }
                Yii::$app->db->createCommand('UNLOCK TABLES')->execute();
            }
        }

        $model->create_by = !empty($model->create_by) ? date('Y-m-d',$model->create_by) : '';
        $model->update_by = !empty($model->update_by) ? date('Y-m-d',$model->update_by) : '';

        return $this->render('create', [
            'model' => $model,
            'bills' => $bills,
            'bill_id' => isset($bill_id) ? $bill_id : Bills::generateId(),
            'shops' => Shop::getAll(),
        ]);
    }

    /**
     * Updates an existing ShopList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_price = $model->final_price;
        $model->create_by = date('Y-m-d',$model->create_by);
        $model->update_by = date('Y-m-d',$model->update_by);
        if ($model->load(Yii::$app->request->post())) {
            $model->create_by = strtotime($model->create_by);
            $model->update_by = strtotime($model->update_by);
            if($model->save()){
                $bills = Bills::find()->where(['bill_id'=>$model->bill_id])->limit(1)->one();
                $bills->price = (double)$bills->price - (double)$old_price + (double)$model->final_price;
                $bills->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
            'shops' => Shop::getAll(),
        ]);
    }

    /**
     * @author: lhh
     * 创建日期：2020-03-18
     * 修改日期：2020-03-18
     * 名称： del
     * 功能：删除冗余的数据
     * 说明：
     * 注意：
     * @throws \yii\db\Exception
     *
     */
    private function del()
    {
        $ids = [];
        $rows = (new \yii\db\Query())
            ->from(Goods::tableName())
            ->all();

        foreach ($rows as $k1 => $v1){
            $total = 0;
            foreach ($rows as $k2 => $v2){
                if($v1['name'] == $v2['name'] && $v1['create_by'] == $v2['create_by'] && $v1['final_price'] == $v2['final_price']){
                    if($total > 0 && !in_array($v2['id'],$ids)){
                        $ids[] = $v2['id'];
                    }
                    $total++;

                }
            }
        }

        if(!empty($ids)){
            $ids = implode(',',$ids);
            Yii::$app->db->createCommand()->delete(Goods::tableName(),"id in({$ids})")->execute();;
        }



    }

    /**
     * Deletes an existing ShopList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id=null)
    {
//        $this->del();
//        exit;
        $model = $this->findModel($id);
        $bills = Bills::find()->where(['bill_id'=>$model->bill_id])->limit(1)->one();
        $bills->price = (double)$bills->price - (double)$model->final_price;
        $bills->save();
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the ShopList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}

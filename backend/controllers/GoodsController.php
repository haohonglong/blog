<?php

namespace backend\controllers;

use backend\models\Shop;
use Yii;
use backend\models\Goods;
use backend\models\GoodsSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShopListController implements the CRUD actions for ShopList model.
 */
class GoodsController extends Controller
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
     * Creates a new ShopList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goods();

        if ($model->load(Yii::$app->request->post())) {
            $model->uid = Yii::$app->user->identity->getId();
            $model->create_by = strtotime($model->create_by);
            $model->update_by = strtotime($model->update_by);
            if(is_array($model->name)){
                $data = [];
                foreach ($model->name as $i => $item){
                    $data[$i]['uid']            = $model->uid;
                    $data[$i]['shop_id']        = $model->shop_id;
                    $data[$i]['create_by']      = $model->create_by;
                    $data[$i]['update_by']      = $model->update_by;
                    $data[$i]['name']           = $model->name[$i];
                    $data[$i]['number']         = $model->number[$i];
                    $data[$i]['weight']         = $model->weight[$i];
                    $data[$i]['single_price']   = $model->single_price[$i];
                    $data[$i]['final_price']    = $model->final_price[$i];
                }
                Yii::$app->db->transaction(function($db) use($data) {
                    $db->createCommand()->batchInsert('goods', [
                        'uid',
                        'shop_id',
                        'create_by',
                        'update_by',
                        'name',
                        'number',
                        'weight',
                        'single_price',
                        'final_price'
                    ], $data)->execute();

                });
            }else{
                $model->save();
            }


        }

        $model->create_by = !empty($model->create_by) ? date('Y-m-d',$model->create_by) : '';
        $model->update_by = !empty($model->update_by) ? date('Y-m-d',$model->update_by) : '';

        return $this->render('create', [
            'model' => $model,
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
        $model->create_by = date('Y-m-d',$model->create_by);
        $model->update_by = date('Y-m-d',$model->update_by);
        if ($model->load(Yii::$app->request->post())) {
            $model->create_by = strtotime($model->create_by);
            $model->update_by = strtotime($model->update_by);
            if($model->save()){
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
        $this->findModel($id)->delete();

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

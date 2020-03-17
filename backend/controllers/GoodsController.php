<?php

namespace backend\controllers;

use backend\models\Shop;
use Yii;
use backend\models\Goods;
use backend\models\GoodsSearch;
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
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalPrice' => Goods::totalPrices(),
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
                foreach ($model->name as $i => $item){
                    $model2 = new Goods();
                    $model2->uid = $model->uid;
                    $model2->shop_id = $model->shop_id;
                    $model2->create_by = $model->create_by;
                    $model2->update_by = $model->update_by;
                    $model2->name = $model->name[$i];
                    $model2->number = $model->number[$i];
                    $model2->weight = $model->weight[$i];
                    $model2->single_price = $model->single_price[$i];
                    $model2->final_price = $model->final_price[$i];
                    $model2->save();
                }

            }else{
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }


        }

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
     * Deletes an existing ShopList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
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

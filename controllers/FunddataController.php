<?php

namespace  rsiripong\scbfund\controllers;

use Yii;
use rsiripong\scbfund\models\Funddata;
use rsiripong\scbfund\models\Fundname;
use rsiripong\scbfund\models\FunddataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use miloschuman\highcharts\SeriesDataHelper;

/**
 * FunddataController implements the CRUD actions for Funddata model.
 */
class FunddataController extends Controller
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
     * Lists all Funddata models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        //foreach(Fundname::find()->all() as $tmp3){
        
        $searchModel = new FunddataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider = $searchModel->search(['FunddataSearch'=>[
        //    'fund_id'=>$tmp3->fund_id
        //]]);
        /*
        foreach($dataProvider->query->all() as $tmp1){
            //print_r($tmp1->attributes);
            
            $model2 = Funddata::findOne($tmp1->funddata_id);
            if( !$model2->datatrans){
            //$model2->attributes = $tmp1->attributes;
            $model2->load(['Funddata' => [
                'datatrans'=>$tmp1->datatrans
            ]]);
            $model2->save();
            //exit;
            }
        }
         * 
         */
        //}

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
 
    }

    /**
     * Displays a single Funddata model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Funddata model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Funddata();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->funddata_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Funddata model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->funddata_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Funddata model.
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
    
    public function actionJsondata($id)
    {
        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $queryall = Funddata::find()->where([
            'fund_id'=>$id
        ])->all();
        
        return new SeriesDataHelper($queryall, ['datadate:datetime','dataprice']);
        
        //$this->findModel($id)->delete();

        //return $this->redirect(['index']);
    }

    /**
     * Finds the Funddata model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Funddata the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Funddata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

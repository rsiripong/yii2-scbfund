<?php

namespace  rsiripong\scbfund\controllers;

use Yii;
use rsiripong\scbfund\models\Fundname;
use rsiripong\scbfund\models\FundnameSearch;
use rsiripong\scbfund\models\Funddata;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\httpclient\Client;


/**
 * FundnameController implements the CRUD actions for Fundname model.
 */
class FundnameController extends Controller
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
     * Lists all Fundname models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FundnameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Fundname model.
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
     * Creates a new Fundname model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Fundname();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->fund_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Fundname model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->fund_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Fundname model.
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

    
    
      public function actionReaddata($date = null,$maxdatadate=null){
        if($date == null){
            //$date = date("Y-m-d");
            $date = new \DateTime();
        }else{
            $date = new \DateTime($date);
        }
        
        if($maxdatadate == null){
            //$date = date("Y-m-d");
            //$date2 = new \DateTime();
            $maxdatadate2 = Funddata::find()->max('datadate');
            
            if($maxdatadate2){
            $date2 = new \DateTime($maxdatadate2);
            }else{
                $date2 = new \DateTime();
                $date2->sub(new \DateInterval('P30D'));
            }
        }else{
            $date2 = new \DateTime($maxdatadate);
        }
        
        $interval = $date->diff($date2);
        //echo intval($interval->format('%r%a'));exit;
        if(intval($interval->format('%r%a')) >=0){
            exit;
        }
        
        
        if($date->format('N') != 6 && $date->format('N') != 7 ){  // skip sat,sun 
            $filename = "https://www.scbam.com/download-nav/2/fund/".$date->format('Y-m-d');
            $client = new Client();
            $response = $client->createRequest()
            //->setMethod('POST')
            ->setUrl($filename)
            ->send();
            if ($response->isOk) {
                $filename = tempnam(sys_get_temp_dir(), "FUND");
                $fp = fopen($filename, 'w+');
                fwrite($fp, $response->content);
                fclose($fp);
                //  $filename = Yii::getAlias('@webroot').'/uploads/fund-2018-05-11.xls';
                // echo $filename;exit;
                //$data = \moonland\phpexcel\Excel::import($fileName, $config); // $config is an optional
                $data = \moonland\phpexcel\Excel::widget([
                        'mode' => 'import', 
                        'fileName' => $filename, 
                        //'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                        //'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
                        'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);
                //print_r($data);
                foreach($data as $tmp1){
                    $tmp2 = array_values($tmp1);
                    if($tmp2[1]){

                        $date1 =  split('/',$tmp2[2]) ;
                        //print_r($tmp2);
                        $tmp3 = [
                            'fundname'=>$tmp2[1], // fundname
                            'funddesc'=>$tmp2[0], // funddesc
                              'datadate'=>($date1[2] - 543)."-".$date1[1]."-".$date1[0], // datadate
                            'dataprice'=>floatval($tmp2[3]), //dataprice
                           'datadiff'=> floatval($tmp2[4]), //datadiff
                           'datapecen'=> floatval($tmp2[5]),  //datapecen
                            'datasummary'=> floatval( str_replace(',','',$tmp2[8] ) ) //datasummary
                        ];
                        //print_r($tmp3);
                        $funddata = new Funddata();
                        $funddata->attributes = $tmp3;
                        //print_r($funddata);
                        //exit;
                        if($funddata->save()){
                           // print_r($funddata->errors);
                        }
                        //exit;
                    }
                }
            }
        }
    //$date = new \DateTime($date);
    $date->sub(new \DateInterval('P1D'));
    //echo $date->format('Y-m-d') 
    $this->redirect(['readdata',
        'date'=>$date->format('Y-m-d'),
        'maxdatadate'=>$date2->format('Y-m-d')
        ]);
    }
    /**
     * Finds the Fundname model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fundname the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fundname::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

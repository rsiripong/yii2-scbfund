<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\helpers\Glib;
use miloschuman\highcharts\Highstock;
use yii\web\JsExpression;
use miloschuman\highcharts\SeriesDataHelper;


/* @var $this yii\web\View */
/* @var $searchModel app\models\FunddataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Funddatas';
$this->params['breadcrumbs'][] = $this->title;

$queryall = $dataProvider->query->all();
?>
<div class="funddata-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Funddata', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php 
    /*
     foreach($dataProvider->getModels() as $tmp1){
        $categories[] = $tmp1['datadate'];
        $data1['dataprice'][] = floatval($tmp1['dataprice']);
        $data2['datapecen'][] = floatval($tmp1['datapecen']);
        $data3['datasummary'][] = floatval($tmp1['datasummary']);
        //$data1['hits'][] = intval( $tmp1['hits']);
    }
     $chartoption = array('type'=> 'column','categories' => $categories);//
     * 
     */
    ?>
    
    <?php
    
    $this->registerJs('$.getJSON("'.Url::to(['funddata/jsondata',
        'id'=>$searchModel->fund_id]).'", myCallbackFunction);');

    //$this->registerJs(" $('.selectrage').click(function (e) {alert('test');})");
echo Highstock::widget([
 'callback' => 'myCallbackFunction',
    
    'options' => [
        
        
'title' => [
            'text' => 'Price'
        ],
        'rangeSelector' =>[
            'selected'=> 0,
            
        ], 
        'series' => [
            [
                // 'compare' => 'percent',
                 // 'type' => 'spline',
                  'name' => 'Stock',
                 // 'data' => new SeriesDataHelper($queryall, ['datadate:datetime','dataprice']),
                 'data' => new JsExpression('data'), // Here we use the callback parameter, data
                'marker'=>[
                     'enabled'=> true,
                'radius'=> 3
                ] 
              ],
            ]
    ]
]);
echo Highstock::widget([

    'options' => [
        
         'title' => [
            'text' => 'Percen'
        ],

        'rangeSelector' =>[
            'selected'=> 0
        ], 
        'series' => [
            [
                  //'type' => 'spline',
                  'name' => 'Stock',
                  'data' => new SeriesDataHelper($queryall, ['datadate:datetime','datapecen']),
                'marker'=>[
                     'enabled'=> true,
                'radius'=> 3
                ] 
              ],
            ]
    ]
]);
echo Highstock::widget([

    'options' => [
        
        'title' => [
            'text' => 'Summary'
        ],

        'rangeSelector' =>[
            'selected'=> 0
        ], 
        'series' => [
            [
                  //'type' => 'spline',
                  'name' => 'Stock',
                  'data' => new SeriesDataHelper($queryall, ['datadate:datetime','datasummary']),
                'marker'=>[
                     'enabled'=> true,
                'radius'=> 3
                ] 
              ],
            ]
    ]
]);

echo Highstock::widget([

   
    'options' => [
 'title' => [
            'text' => 'Trans'
        ],
        'rangeSelector' =>[
            'selected'=> 0
        ], 
        'series' => [
            [
                  //'type' => 'spline',
                  'name' => 'Stock',
                  'data' => new SeriesDataHelper($queryall, ['datadate:datetime','datatrans']),
                'marker'=>[
                     'enabled'=> true,
                'radius'=> 3
                ] 
              ],
            ]
    ]
]);
    

    ?>
    
    
    
    <?php
    
    //echo Glib::highchartsRender($data1,$graphtitle,$chartoption);
    // echo Glib::highchartsRender($data2,$graphtitle,$chartoption);
    // echo Glib::highchartsRender($data3,$graphtitle,$chartoption);
            ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>"{pager}\n{summary}\n{items}\n{summary}\n{pager}",
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            ///'funddata_id',
            //'fund_id',
            'datadate',
            'dataprice',
            'datadiff',
            'datapecen',
            'datasummary:decimal',
            'datatrans:decimal',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\grid\GridView;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\Highstock;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FundstockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fundstocks';
$this->params['breadcrumbs'][] = $this->title;

global $sumcurrentcost;
$sumcurrentcost = 0;
$chartdata['categories'] = [];
$chartdata['data'] = [];
$queryall = $dataProvider->query->all();
foreach($queryall as $model){
    
    //print_r($tmp1);exit;
    $sumcurrentcost +=  $model->dataunit * $model->lastfunddata->dataprice;
    
    
}
foreach($queryall as $model){
    $chartdata['ids'][] = $model->fundname->fund_id;
    $chartdata['categories'][] = $model->fundname->fundname;
    $chartdata['data'][] = [
        'name'=>$model->fundname->fundname,
        'y'=> ($model->dataunit * $model->lastfunddata->dataprice * 100) / $sumcurrentcost
    ];
}

//print_r($chartdata);
?>
<div class="fundstock-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Fundstock', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php

//$datas = $dataProvider->query->all();
//print_r($chartdata);
echo Highcharts::widget([
   'options' => [
       'chart'=> [ 
          // 'plotBackgroundColor'=> null,
        //'plotBorderWidth'=> null,
        //'plotShadow'=> false,
        'type'=> 'pie',
           'options3d'=> [
            'enabled'=> true,
            'alpha'=> 45,
            'beta'=> 0
        ]
           ],
       'plotOptions'=> [
        'pie'=> [
            'allowPointSelect'=> true,
            'cursor'=> 'pointer',
             'innerSize'=> 100,  // donut
             'depth'=> 35,
            'dataLabels'=> [
                'enabled'=> true,
                'format'=> '<b>{point.name}</b>: {point.percentage:.1f} %',
                //'styl'=> [
                //    'color'=> (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
               // ]
            ]
        ]
    ],
       
    
      'title' => ['text' => ''],
     // 'xAxis' => [
      //  'categories' =>   $chartdata['categories']
      //],
      'series' => [
         [
             'name' => 'Ratio', 
             'data'=> $chartdata['data']
         ],
      ]
   ],
    'scripts' => [
        'highcharts-3d',
   'highcharts-more',   // enables supplementary chart types (gauge, arearange, columnrange, etc.)
   'modules/exporting', // adds Exporting button/menu to chart
  // 'themes/grid'        // applies global 'grid' theme to all charts
],
]);

?>
    
    <?php
    
    
    // $this->registerJs('$.getJSON("'.Url::to(['funddata/jsondata',
     //   'id'=>14]).'", myCallbackFunction);');

    //$this->registerJs(" $('.selectrage').click(function (e) {alert('test');})");
    
    $urldata = Url::to(['funddata/jsondata']);
    $ids = implode("','", $chartdata['ids'])  ;
    $names = implode("','",$chartdata['categories']);
    
    
    $js = <<<MOO
    $(function () {
        var seriesOptions = [],
            seriesCounter = 0,
            ids = ['$ids'];
            names = ['$names'];

        $.each(ids, function(i, id) {

            $.getJSON('$urldata?id='+ id +'',	function(data) {

                seriesOptions[i] = {
                    name: names[i],
                    data: data
                };

                // As we're loading the data asynchronously, we don't know what order it will arrive. So
                // we keep a counter and create the chart when all the data is loaded.
                seriesCounter++;
           
                if (seriesCounter == names.length) {
                    createChart(seriesOptions);
                }
            });
        });
    });
MOO;
    
    /*
    $js = <<<MOO
    $(function () {
        var seriesOptions = [],
            seriesCounter = 0,
            names = ['MSFT', 'AAPL', 'GOOG'];

        $.each(names, function(i, name) {

            $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename='+ name.toLowerCase() +'-c.json&callback=?',	function(data) {

                seriesOptions[i] = {
                    name: name,
                    data: data
                };

                // As we're loading the data asynchronously, we don't know what order it will arrive. So
                // we keep a counter and create the chart when all the data is loaded.
                seriesCounter++;

                if (seriesCounter == names.length) {
                    createChart(seriesOptions);
                }
            });
        });
    });
MOO;
*/
$this->registerJs($js);
    
    echo Highstock::widget([
    // The highcharts initialization statement will be wrapped in a function
    // named 'createChart' with one parameter: data.
    'callback' => 'createChart',
    'options' => [
        'rangeSelector' => [
            'selected' => 4
        ],
        'yAxis' => [
            'labels' => [
                'formatter' => new JsExpression("function () {
                    return (this.value > 0 ? ' + ' : '') + this.value + '%';
                }")
            ],
            'plotLines' => [[
                'value' => 0,
                'width' => 2,
                'color' => 'silver'
            ]]
        ],
        'plotOptions' => [
            'series' => [
                'compare' => 'percent'
            ]
        ],
        'tooltip' => [
            'pointFormat' => '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
            'valueDecimals' => 2
        ],
        'series' => new JsExpression('data'), // Here we use the callback parameter, data
    ]
]);
    /*
echo Highstock::widget([
 //'callback' => 'myCallbackFunction',
    'callback' => 'createChart',
    
    'options' => [
        
        
'title' => [
            'text' => 'Price'
        ],
        'rangeSelector' =>[
            'selected'=> 0,
            
        ], 
        'series' => [
            [
                 'compare' => 'percent',
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

*/
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'showPageSummary' => true,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'fundstock_id',
            //'fund_id',
            
            //'datadate',
            //'fundname.fundname',
            [
                'attribute' => 'fundname.fundname',
                'format'=>'raw',
                'value'=> function($model){
                    return  Html::a($model->fundname->fundname,Url::to(['funddata/index',
                        'FunddataSearch'=>['fund_id'=>$model->fund_id]
                    ]),['target'=>'_blank']) ;
                }
            ],
                     //'dataunit',
                    [
                        'attribute' => 'dataunit',
                         'format'=>['decimal',2],
                        'contentOptions' => ['class' => 'text-right'],
                    ],
            [
                'attribute' => 'startcost',
                //'label'=>'startcost',
                //'format'=>'decimal',
                'format'=>['decimal',2],
               // 'value'=>function($model){
                //     return $model->dataunit * $model->dataprice;
                //},
                        'contentOptions' => ['class' => 'text-right'],
               // 'class' => '\kartik\grid\DataColumn',
       // 'attribute' => 'amount',
        'pageSummary' => true
            ],
            [
                'attribute' => 'currentcost',
                 //'format'=>'decimal',
                 'format'=>['decimal',2],
                //'label'=>'currentcost',
                //'value'=>function($model){
                //     return $model->dataunit * $model->lastfunddata->dataprice;
                //},
                        'contentOptions' => ['class' => 'text-right'],
                'pageSummary' => true,
            ],
                        
            [
                 //'format'=>'decimal',
                 'format'=>['decimal',2],
                'label'=>'Ratio %',
                'value'=>function($model){
                    global $sumcurrentcost;
                     return ($model->dataunit * $model->lastfunddata->dataprice * 100) / $sumcurrentcost;
                },
                        'contentOptions' => ['class' => 'text-right'],
                'pageSummary' => true,
            ],
                    
                    [
                       // 'class' => '\kartik\grid\DataColumn',
                        // 'format'=>'decimal',
                        'attribute' => 'diffcost',
                 //'format'=>'decimal',
                         'format'=>['decimal',2],
                //'label'=>'diffcost',
               // 'value'=>function($model){
                 //    return $model->dataunit * ($model->lastfunddata->dataprice - $model->dataprice );
                //},
                        'contentOptions' => ['class' => 'text-right'],
                'pageSummary' => true,
            ],
                        
                        
                  
                    
            //'datadate',
            [
                'value'=>function($model){return "  ";}
            ],
            'lastfunddata.datadate',
                        [
                             //'format'=>'decimal',
                             'format'=>['decimal',3],
                            //'label'=>'Start Price',
                            //'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'dataprice',
                           // 'pageSummary' => true,
                            'contentOptions' => ['class' => 'text-right'],
            
                        ],
                         [
                             //'format'=>'decimal',
                             'format'=>['decimal',3],
                            // 'label'=>'Current Price',
                            //'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'lastfunddata.dataprice',
                           // 'pageSummary' => true,
                            'contentOptions' => ['class' => 'text-right'],
            
                        ],
                         [
                       // 'class' => '\kartik\grid\DataColumn',
                         //'format'=>'decimal',
                             'attribute' => 'diffpercen',
                   'format'=>['decimal',2],
                //'label'=>'diffpercen',
                //'value'=>function($model){
                     //return $model->dataunit * ($model->lastfunddata->dataprice - $model->dataprice );
                 //   return ( (  $model->lastfunddata->dataprice / $model->dataprice )-1 )*100;
               // },
                        'contentOptions' => ['class' => 'text-right'],
                //'pageSummary' => true,
            ],       
                        
            
           // 'funddata.datapecen',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
</div>

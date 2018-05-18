<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\grid\GridView;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FundnameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fundnames';
$this->params['breadcrumbs'][] = $this->title;


$sumcurrentcost = 0;
$chartdata['categories'] = [];
$chartdata['data'] = [];

$queryall = $dataProvider->query->all();

foreach($queryall as $model){
    
    //print_r($tmp1);exit;
    $sumcurrentcost +=  $model->lastfunddata->datasummary;
    
    
}
foreach($queryall as $model){
    $chartdata['categories'][] = $model->fundname->fundname;
    $chartdata['data'][] = [
        'name'=>$model->fundname,
        'y'=> $model->lastfunddata->datasummary
    ];
}
?>
<div class="fundname-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Fundname', ['create'], ['class' => 'btn btn-success']) ?>
         <?= Html::a('Update Data',Url::to(['readdata']), ['class' => 'btn btn-primary','target'=>'_blank']) ?>
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
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'showPageSummary' => true,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            //'fund_id',
            //'fundname',
            [
                'attribute' => 'fundname',
                'format'=>'raw',
                'value'=> function($model){
                    return  Html::a($model->fundname,Url::to(['funddata/index',
                        'FunddataSearch'=>['fund_id'=>$model->fund_id]
                    ]),['target'=>'_blank']) ;
                }
            ],
            'funddesc',
                    'lastfunddata.datadate',
                    
                        [
                            'format'=>['decimal',3],
                        'contentOptions' => ['class' => 'text-right'],
                            'attribute' => 'lastfunddata.dataprice',
                        ],
                   
                    [
                            'format'=>['decimal',3],
                        'contentOptions' => ['class' => 'text-right'],
                            'attribute' => 'lastfunddata.datapecen',
                        ],
                    
                    [
                             'format'=>['decimal',2],
                        'contentOptions' => ['class' => 'text-right'],
                             'attribute' =>'lastfunddata.datasummary',
                         'pageSummary' => true,
                        ],
                     
                    [
                             'format'=>['decimal',2],
                        'contentOptions' => ['class' => 'text-right'],
                            'attribute' => 'lastfunddata.datatrans',
                         'pageSummary' => true,
                        ],
                    
                    //'lastfunddata.datapecen',
                    //'lastfunddata.datasummary:decimal',
                    //'lastfunddata.datatrans:decimal',


            //['class' => 'yii\grid\ActionColumn'],
                    ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
</div>

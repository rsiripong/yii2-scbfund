<?php

namespace rsiripong\scbfund\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use rsiripong\scbfund\models\Funddata;
use yii\data\Sort;
use yii\db\Query;

/**
 * FunddataSearch represents the model behind the search form of `app\models\Funddata`.
 */
class FunddataSearch extends Funddata
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['funddata_id', 'fund_id'], 'integer'],
            [['datadate'], 'safe'],
            [['dataprice', 'datadiff', 'datapecen', 'datasummary'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        // 
        /*
        $subQuery = (new Query())->select('tbfunddata.datasummary - ( tb2.datasummary * (1+(datapecen /100 )))')
                ->from('tbfunddata tb2')
                //->where('tb2.fund_id =tbfunddata.fund_id and tb2.datadate =  SUBDATE(tbfunddata.datadate,INTERVAL 1 day)');
        ->where('tb2.fund_id =tbfunddata.fund_id and tb2.datadate =  date2');
        //(select tb3.datadate from tbfunddata tb3 where tbfunddata.datadate > tb3.datadate order by tb3.datadate DESC limit 0 ,1)
        $subquery2 = (new Query())->select('tb3.datadate')
                ->from('tbfunddata tb3')
                ->where('tbfunddata.datadate > tb3.datadate')
                ->orderBy(['tb3.datadate'=>SORT_DESC])
                ->limit(1);
        */
        $query = Funddata::find()
                /*->select(
                ['funddata_id' ,
            'fund_id' ,
            'datadate',
            'dataprice' ,
            'datadiff' ,
            'datapecen' ,
            'datasummary' ,
            'datatrans'
            //'date2'=>$subquery2,
            //'datatrans'=>$subQuery
                    ]
                )
                 * 
                 */
                ;
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
        'pageSize' => 60,
    ],
            
            
            'sort'=> new Sort([
        'attributes' => [
            'datadate'
            /*
            'datadate' => [
                
                'asc' => [
                    'datadate' => SORT_ASC
                    //, 'last_name' => SORT_ASC
                    ],
                'desc' => [
                    'datadate' => SORT_DESC
                    //, 'last_name' => SORT_DESC
                    ],
                
                'default' => SORT_DESC,
                //'label' => 'Name',
            ],
             * 
             */
            
            
        ],
               
               'defaultOrder'=>['datadate' => SORT_DESC],
    ])
            
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'funddata_id' => $this->funddata_id,
            'fund_id' => $this->fund_id,
            'datadate' => $this->datadate,
            'dataprice' => $this->dataprice,
            'datadiff' => $this->datadiff,
            'datapecen' => $this->datapecen,
            'datasummary' => $this->datasummary,
        ]);

        return $dataProvider;
    }
}

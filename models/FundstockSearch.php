<?php

namespace rsiripong\scbfund\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use rsiripong\scbfund\models\Fundstock;
use \yii\data\Sort;

/**
 * FundstockSearch represents the model behind the search form of `app\models\Fundstock`.
 */
class FundstockSearch extends Fundstock
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fundstock_id', 'fund_id'], 'integer'],
            [['datadate'], 'safe'],
            [['dataunit'], 'number'],
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
        $query = Fundstock::find()
                ->select([
                    /*
                    'tbfundstock.*',
                    "startcost"=>"`tbfundstock`.dataunit * `tbfundstock`.dataprice",
                    "currentcost"=>"`tbfundstock`.dataunit * `lastfunddata`.dataprice",
                    "diffcost" => "`tbfundstock`.dataunit * (`lastfunddata`.dataprice - `tbfundstock`.dataprice)",
                    "diffpercen"=>"((`lastfunddata`.dataprice / `tbfundstock`.dataprice) - 1) *100"
                     * 
                     */
                    '{{%tbfundstock}}.*',                  
                    "startcost"=>"{{%tbfundstock}}.dataunit * {{%tbfundstock}}.dataprice",
                    "currentcost"=>"{{%tbfundstock}}.dataunit * {{%tbfundstock}}.dataprice",
                    "diffcost" => "{{%tbfundstock}}.dataunit * (`lastfunddata`.dataprice - {{%tbfundstock}}.dataprice)",
                    "diffpercen"=>"((`lastfunddata`.dataprice / {{%tbfundstock}}.dataprice) - 1) *100"
                   
                ])
                ->joinWith([ 'fundname fundname', 'lastfunddata lastfunddata']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>new Sort([
                'attributes'=>[
                    //'datadate',
                    'dataunit',
                    'dataprice',

                    'fundname.fundname',
                    'startcost',
                    'currentcost',
                    'diffcost',
                    'diffpercen',
                    'lastfunddata.dataprice',
                     'lastfunddata.datadate'

                ]
                    ,
                //'defaultOrder'=>[
                 //   'accessdate'=>SORT_DESC
                   // ]
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
            'fundstock_id' => $this->fundstock_id,
            'fund_id' => $this->fund_id,
            'datadate' => $this->datadate,
            'dataunit' => $this->dataunit,
        ]);

        return $dataProvider;
    }
}

<?php

namespace rsiripong\scbfund\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use rsiripong\scbfund\models\Fundname;
use yii\data\Sort;

/**
 * FundnameSearch represents the model behind the search form of `app\models\Fundname`.
 */
class FundnameSearch extends Fundname
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fund_id'], 'integer'],
            [['fundname', 'funddesc'], 'safe'],
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
        $query = Fundname::find()
                
                ->joinWith(['lastfunddata lastfunddata']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
                        'sort'=>new Sort([
                'attributes'=>[
                'fundname',
                    'funddesc',
                    'lastfunddata.datadate',
                    'lastfunddata.dataprice',
                    'lastfunddata.datapecen',
                    'lastfunddata.datasummary',
                    'lastfunddata.datatrans'

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
            'fund_id' => $this->fund_id,
        ]);

        $query->andFilterWhere(['like', 'fundname', $this->fundname])
            ->andFilterWhere(['like', 'funddesc', $this->funddesc]);

        return $dataProvider;
    }
}

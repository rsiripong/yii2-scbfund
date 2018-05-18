<?php

namespace rsiripong\scbfund\models;


use rsiripong\scbfund\Module;
use Yii;

/**
 * This is the model class for table "tbfundstock".
 *
 * @property int $fundstock_id
 * @property int $fund_id
 * @property string $datadate
 * @property double $dataunit
 */
class Fundstock extends \yii\db\ActiveRecord
{
    
    //var $startcost;
    //var $currentcost;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbfundstock}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fund_id', 'datadate'], 'required'],
            [['fund_id'], 'integer'],
            [['datadate'], 'safe'],
            [['dataunit','dataprice'], 'number'],
            [['fund_id', 'datadate'], 'unique', 'targetAttribute' => ['fund_id', 'datadate']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fundstock_id' => 'Fundstock ID',
            'fund_id' => 'Fund ID',
            'datadate' => Module::t('app','Datadate'),
            'dataunit' => Module::t('app','Dataunit'),
            'dataprice'=> Module::t('app','Start price'),
        ];
    }
    /*
    public function getLastfunddata(){
        return $this->hasOne(Funddata::className(), [
            'fund_id' => 'fund_id',
            //'datadate'=>'lastdatadate'
            ])
                ->orderBy(['datadate'=>SORT_DESC])->limit(1);
    }
     * 
     */
    public function getFundname(){
        return $this->hasOne(Fundname::className(), ['fund_id' => 'fund_id']);
    }
    
    public function getStartCost(){
        return $this->dataunit * $this->dataprice;
    }
    
    public function getCurrentCost(){
        return $this->dataunit * $this->lastfunddata->dataprice;
    }
    
    public function getDiffCost(){
        return  $this->dataunit * ($this->lastfunddata->dataprice - $this->dataprice );
    }
    
    public function getDiffPercen(){
         return ( (  $this->lastfunddata->dataprice / $this->dataprice )-1 )*100;
    }
   
    
     public function getLastfunddata(){
         return $this->hasOne(Funddata::className(), [
            'fund_id' => 'fund_id',
            'datadate'=>'lastdatadate'
            ])->via('fundname');
     }
            
}

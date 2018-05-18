<?php

namespace rsiripong\scbfund\models;

use rsiripong\scbfund\models\Fundname;
use rsiripong\scbfund\Module;
use yii\db\Query;

use Yii;

/**
 * This is the model class for table "funddata".
 *
 * @property int $funddata_id
 * @property int $fund_id
 * @property string $datadate
 * @property double $dataprice
 * @property double $datadiff
 * @property double $datapecen
 * @property double $datasummary
 */
class Funddata extends \yii\db\ActiveRecord
{
    var $fundname;
    var $funddesc;
    //var $datatrans;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbfunddata}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'datadate'], 'required'],
            [['fund_id'], 'integer'],
            [['datadate'], 'safe'],
            [['dataprice', 'datadiff', 'datapecen', 'datasummary','datatrans'], 'number'],
            //[['fund_id', 'datadate'], 'unique', 'targetAttribute' => ['fund_id', 'datadate']],
            [['fundname'], 'string', 'max' => 50],
            [['funddesc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'funddata_id' => 'Funddata ID',
            'fund_id' => 'Fund ID',
            'datadate' => Module::t('app','Datadate'),
            'dataprice' => Module::t('app','Current price'),
            'datadiff' => Module::t('app','Datadiff'),
            'datapecen' => Module::t('app','Datapecen'),
            'datasummary' => Module::t('app','Datasummary'),
            'datatrans' => Module::t('app','Datatrans'),
        ];
    }
    
    function getCalDataTrans(){
        
         if($this->fundname){
             $fundname= Fundname::find()->where(['fundname'=>$this->fundname])->one();
         }
        
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
        
        $query = Funddata::find()->where([
            '<','datadate',$this->datadate
                   // 'funddata_id2'=>$this->funddata_id
                ])->andWhere(['fund_id'=>$fundname->fund_id])
                ->orderBy(['datadate'=>SORT_DESC])
                ->limit(1)
                ->one();
        
       // print_r($query);exit;
        
       return $this->datasummary   - ($query->datasummary * (1 + ($this->datapecen/100)));
        
    }
   
    public function beforeSave($insert) {
       //echo "test";exit;
        if(parent::beforeSave($insert)){
            
            
            if(!$this->datatrans){
                $this->datatrans = $this->getCalDataTrans();
            }
            if($this->fundname){
             $fundname= Fundname::find()->where(['fundname'=>$this->fundname])->one();
        if(!$fundname){
            
            $fundname = new Fundname();
            $fundname->attributes = [
                'fundname'=>$this->fundname,
                 'funddesc'=>$this->funddesc,
                'lastdatadate'=>$this->datadate
                    ];
             
            
           
            
        }else{
            
            $datetime1 = new \DateTime($fundname->lastdatadate);
            $datetime2 = new \DateTime($this->datadate);
            //$interval = $datetime1->diff($datetime2);
            if(!$fundname->lastdatadate || ($datetime2 > $datetime1)){
                $fundname->lastdatadate = $this->datadate;
                
               // echo $fundname->lastdatadate."|".$this->datadate;
            //exit;
            }
        }
        
        
        
        
        
        $fundname->save();
        $this->fund_id = $fundname->fund_id;
       
        if(Funddata::find()->where([
            'fund_id'=>$this->fund_id,
            'datadate'=>$this->datadate,
        ])->one()){
            return false;
        }
         }
         return true;
    } else {
        return false;
    }
        
       
        
    }
}

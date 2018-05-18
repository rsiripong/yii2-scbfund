<?php

namespace rsiripong\scbfund\models;


use rsiripong\scbfund\Module;
use Yii;

/**
 * This is the model class for table "fundname".
 *
 * @property int $fund_id
 * @property string $fundname
 * @property string $funddesc
 */
class Fundname extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbfundname}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fundname'], 'string', 'max' => 50],
            [['funddesc'], 'string', 'max' => 255],
            [['lastdatadate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fund_id' => 'Fund ID',
            'fundname' => Module::t('app','Fundname'),
            'funddesc' => Module::t('app','Funddesc'),
        ];
    }
    
    
    
    public function getLastfunddata(){
        return $this->hasOne(Funddata::className(), [
            'fund_id' => 'fund_id',
            'datadate'=>'lastdatadate'
            ]);
               // ->orderBy(['datadate'=>SORT_DESC])->limit(1);
    }
}

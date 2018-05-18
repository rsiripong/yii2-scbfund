<?php

namespace rsiripong\scbfund\models;

use Yii;
use yii\base\Model;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class StocktransForm extends Model
{
    public $datadate;
    
    public $sourcefund_id;
    public $sourcedataprice;
    public $sourcedataunit;
    public $sourcedatamoney;
    
    public $targetfund_id;
    public $targetdataprice;
    public $targetdataunit;
    
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['datadate', 'sourcefund_id', 'sourcedataprice', 'targetfund_id','targetdataprice',
                'sourcedataunit','targetdataunit','sourcedatamoney'], 'required'],
            // email has to be a valid email address
            //['email', 'email'],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
        ];
    }
}
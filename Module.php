<?php
namespace rsiripong\scbfund;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\base\Module as BaseModule;
use Yii;
class Module extends BaseModule
{
     public function init()
    {
      
       
        parent::init();
        $this->registerTranslations();
        
    }
    
    
      public function getMenu()
    {
       return [
           [
                        'label' => 'Scbfund',
                        
                        
                        'items' => [
                            ['label' => 'Fund Name',  'url' => ['/scbfund/fundname/index'],],
                             ['label' => 'Fund Stock',  'url' => ['/scbfund/fundstock/index'],],
                            // ['label' => 'Fund Data',  'url' => ['funddata/index'],],
                            
                        ]
               ]
       ];
    }
    
    
       public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/scbfund/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            //'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/scbfund/messages',
            'fileMap' => [
                'modules/scbfund/app' => 'app.php',
                //'modules/enopcalendar/user' => 'user.php',
                //'modules/personalinfo/form' => 'form.php',
               // ...
            ],
        ];
    }
    
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/scbfund/' . $category, $message, $params, $language);
    }
}
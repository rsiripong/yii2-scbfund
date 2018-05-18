<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use rsiripong\juidatepicker\JuiDatePicker;
use rsiripong\scbfund\models\Fundname;
use rsiripong\scbfund\models\Fundstock;

/* @var $this yii\web\View */
/* @var $model app\models\Fundstock */

$this->title = 'Update Fundstock: ' . $model->sourcefund_id;
$this->params['breadcrumbs'][] = ['label' => 'Fundstocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sourcefund_id, 'url' => ['view', 'id' => $model->sourcefund_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fundstock-update">

    <h1><?= Html::encode($this->title) ?></h1>

    
<div class="fundstock-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'datadate')->textInput()->widget(JuiDatePicker::classname()) ?>

     <?= $form->field($model, 'sourcefund_id')->dropDownList( ArrayHelper::map(Fundstock::find()
        //->where(['in','fund_id',[6,7,14,18,74,81,96,97,98]])
        ->all(),"fund_id","fundname.fundname") ) ?>

    
     <?= $form->field($model, 'sourcedatamoney')->textInput([
          'onblur'=>'jQuery(\'#stocktransform-sourcedataunit\').val( jQuery(this).val() / jQuery(\'#stocktransform-sourcedataprice\').val()  )'
     ]) ?>
    <?= $form->field($model, 'sourcedataprice')->textInput() ?>
    <?= $form->field($model, 'sourcedataunit')->textInput([
        'onblur'=>'jQuery(\'#stocktransform-sourcedatamoney\').val( jQuery(this).val() * jQuery(\'#stocktransform-sourcedataprice\').val() )'
    ]) ?>
    
    <hr/>
    
       <?= $form->field($model, 'targetfund_id')->dropDownList( ArrayHelper::map(Fundname::find()
        //->where(['in','fund_id',[6,7,14,18,74,81,96,97,98]])
        ->all(),"fund_id","fundname") ) ?>
    
     <?= $form->field($model, 'targetdataprice')->textInput() ?>
    <?= $form->field($model, 'targetdataunit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>

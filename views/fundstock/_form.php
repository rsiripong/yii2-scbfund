<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use rsiripong\juidatepicker\JuiDatePicker;
use rsiripong\scbfund\models\Fundname;

/* @var $this yii\web\View */
/* @var $model app\models\Fundstock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fundstock-form">

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'fund_id')->dropDownList( ArrayHelper::map(Fundname::find()
        //->where(['in','fund_id',[6,7,14,18,74,81,96,97,98]])
        ->all(),"fund_id","fundname") ) ?>

    <?= $form->field($model, 'datadate')->textInput()->widget(JuiDatePicker::classname()) ?>

    <?= $form->field($model, 'dataunit')->textInput() ?>
    <?= $form->field($model, 'dataprice')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

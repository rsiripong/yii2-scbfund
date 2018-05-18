<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use rsiripong\scbfund\models\Fundname;

/* @var $this yii\web\View */
/* @var $model app\models\FunddataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="funddata-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // $form->field($model, 'funddata_id') ?>

    <?= $form->field($model, 'fund_id')->dropDownList( ArrayHelper::map(Fundname::find()
        //->where(['in','fund_id',[6,7,14,18,74,81,96,97,98]])
        ->all(),"fund_id","fundname") ) ?>

    <?php //$form->field($model, 'datadate') ?>

    <?php // $form->field($model, 'dataprice') ?>

    <?php // $form->field($model, 'datadiff') ?>

    <?php // echo $form->field($model, 'datapecen') ?>

    <?php // echo $form->field($model, 'datasummary') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

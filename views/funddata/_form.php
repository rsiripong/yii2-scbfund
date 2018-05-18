<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Funddata */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="funddata-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fund_id')->textInput() ?>

    <?= $form->field($model, 'datadate')->textInput() ?>

    <?= $form->field($model, 'dataprice')->textInput() ?>

    <?= $form->field($model, 'datadiff')->textInput() ?>

    <?= $form->field($model, 'datapecen')->textInput() ?>

    <?= $form->field($model, 'datasummary')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

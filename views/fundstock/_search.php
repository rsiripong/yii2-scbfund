<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FundstockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fundstock-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'fundstock_id') ?>

    <?= $form->field($model, 'fund_id') ?>

    <?= $form->field($model, 'datadate') ?>

    <?= $form->field($model, 'dataunit') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

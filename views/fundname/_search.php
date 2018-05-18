<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FundnameSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fundname-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'fund_id') ?>

    <?= $form->field($model, 'fundname') ?>

    <?= $form->field($model, 'funddesc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>

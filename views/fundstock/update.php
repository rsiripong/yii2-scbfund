<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fundstock */

$this->title = 'Update Fundstock: ' . $model->fundstock_id;
$this->params['breadcrumbs'][] = ['label' => 'Fundstocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fundstock_id, 'url' => ['view', 'id' => $model->fundstock_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fundstock-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

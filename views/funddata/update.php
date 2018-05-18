<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Funddata */

$this->title = 'Update Funddata: ' . $model->funddata_id;
$this->params['breadcrumbs'][] = ['label' => 'Funddatas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->funddata_id, 'url' => ['view', 'id' => $model->funddata_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="funddata-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

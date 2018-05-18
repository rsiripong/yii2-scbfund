<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Funddata */

$this->title = 'Create Funddata';
$this->params['breadcrumbs'][] = ['label' => 'Funddatas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="funddata-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

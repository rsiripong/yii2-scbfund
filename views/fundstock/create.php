<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Fundstock */

$this->title = 'Create Fundstock';
$this->params['breadcrumbs'][] = ['label' => 'Fundstocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fundstock-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

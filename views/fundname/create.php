<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Fundname */

$this->title = 'Create Fundname';
$this->params['breadcrumbs'][] = ['label' => 'Fundnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fundname-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

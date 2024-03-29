<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Reservation */
/* @var $tableIds array */

$this->title = 'Update Reservation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reservations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reservation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tableIds' => $tableIds,
    ]) ?>

</div>

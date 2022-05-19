<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Reservation */
/* @var $tableIds array */

$this->title = 'Create Reservation';
$this->params['breadcrumbs'][] = ['label' => 'Reservations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tableIds' => $tableIds
    ]) ?>

</div>

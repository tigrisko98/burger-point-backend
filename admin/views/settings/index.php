<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Settings */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = 'Settings';
?>
<div class="settings-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <a href="/settings/restaurant-images" class="btn btn-secondary">Restaurant images</a>
    <a href="/settings/about-us-images" class="btn btn-secondary">About us images</a>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

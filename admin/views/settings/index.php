<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Settings */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = 'Settings';
?>
<div class="settings-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <a href="/settings/restaurant-images">Restaurant images</a>
    <a href="/settings/about-us-images">About us images</a>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

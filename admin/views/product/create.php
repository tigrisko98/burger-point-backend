<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $modelUpload \admin\models\forms\UploadImageForm */
/* @var array $categoriesTitles */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUpload' => $modelUpload,
        'categoriesTitles' => $categoriesTitles
    ]) ?>

</div>

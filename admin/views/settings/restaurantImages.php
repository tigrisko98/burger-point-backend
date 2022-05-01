<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Settings */
/* @var $modelUpload admin\models\forms\UploadImagesForm */
/* @var array $restaurantImagesLinksArray */

$this->title = 'Restaurant images';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Restaurant images';
?>
<div class="settings-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($restaurantImagesLinksArray)): ?>

        <?php foreach ($restaurantImagesLinksArray as $link): ?>
            <img src="<?= $link ?>" alt="restaurant-image" style="width: 200px">
        <?php endforeach; ?>

    <?php endif; ?>

    <?= $this->render('_restaurantImagesForm', [
        'model' => $model,
        'modelUpload' => $modelUpload,
        'restaurantImagesLinksArray' => unserialize($model->restaurant_images_links),
    ]) ?>

</div>

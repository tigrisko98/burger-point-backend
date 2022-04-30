<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Settings */
/* @var $modelUploadAboutUsImages admin\models\forms\UploadMultipleImagesForm */
/* @var $modelUploadRestaurantImages admin\models\forms\UploadMultipleImagesForm */
/* @var array $aboutUsImagesLinksArray */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = 'Settings';
?>
<div class="settings-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUploadAboutUsImages' => $modelUploadAboutUsImages,
        'modelUploadRestaurantImages' => $modelUploadRestaurantImages,
        'restaurantImagesLinksArray' => unserialize($model->restaurant_images_links),
        'aboutUsImagesLinksArray' => unserialize($model->about_us_images_links)
    ]) ?>

</div>

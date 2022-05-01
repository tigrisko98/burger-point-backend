<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Settings */
/* @var $modelUpload admin\models\forms\UploadImagesForm */
/* @var array $aboutUsImagesLinksArray */

$this->title = 'About us images';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'About us images';
?>
<div class="settings-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($aboutUsImagesLinksArray)): ?>

        <?php foreach ($aboutUsImagesLinksArray as $link): ?>
            <img src="<?= $link ?>" alt="about-us-image" style="width: 200px">
        <?php endforeach; ?>

    <?php endif; ?>

    <?= $this->render('_aboutUsImagesForm', [
        'model' => $model,
        'modelUpload' => $modelUpload,
        'aboutUsImagesLinksArray' => unserialize($model->about_us_images_links),
    ]) ?>

</div>

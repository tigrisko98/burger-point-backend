<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Settings */
/* @var $form yii\widgets\ActiveForm */
/* @var $modelUpload admin\models\forms\UploadImagesForm */
/* @var array $restaurantImagesLinksArray */
?>

<div class="restaurant-images-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($modelUpload, 'images[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])
        ->label('Attach photos for Contacts page:') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

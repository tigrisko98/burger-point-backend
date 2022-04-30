<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Settings */
/* @var $form yii\widgets\ActiveForm */
/* @var $modelUploadAboutUsImages admin\models\forms\UploadMultipleImagesForm */
/* @var $modelUploadRestaurantImages admin\models\forms\UploadMultipleImagesForm */
/* @var array $restaurantImagesLinksArray */
/* @var array $aboutUsImagesLinksArray */
?>

<div class="settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container">
        <h4 style="text-align: center">Contacts</h4>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'telegram_link')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'instagram_link')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'facebook_link')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-3" style="padding-top: 75px">
                <?= $form->field($modelUploadRestaurantImages, 'restaurantImages[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])
                    ->label('Attach photos for Contacts page:') ?>
            </div>

            <?php if (!empty($restaurantImagesLinksArray)): ?>
                <div class="col-md-9">
                    <?php foreach ($restaurantImagesLinksArray as $link): ?>
                        <img src="<?= $link ?>" alt="restaurant-image" style="width: 200px">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
        <br>

        <h4 style="text-align: center">About us</h4>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'about_us_text')->textarea(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <?= $form->field($modelUploadAboutUsImages, 'aboutUsImages[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])
                    ->label('Attach photos for About Us page:') ?>
            </div>

            <?php if (!empty($aboutUsImagesLinksArray)): ?>
                <div class="col-md-9">
                    <?php foreach ($aboutUsImagesLinksArray as $link): ?>
                        <img src="<?= $link ?>" alt="about-us-image" style="width: 200px">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
        <br>

        <h4 style="text-align: center">Others</h4>
        <hr>
        <?= $form->field($model, 'work_schedule')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'restaurant_name')->textInput(['maxlength' => true]) ?>


    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

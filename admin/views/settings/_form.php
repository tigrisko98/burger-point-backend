<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Settings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-form">

    <?php $form = ActiveForm::begin(['id' => 'settings']); ?>

    <div class="container">
        <h5 style="text-align: center">Contacts</h5>
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

        </div>

        <h5 style="text-align: center">About us</h5>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'about_us_text')->textarea(['maxlength' => true]) ?>
            </div>
        </div>

        <h5 style="text-align: center">Others</h5>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'work_schedule')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'restaurant_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'name' => 'settings']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



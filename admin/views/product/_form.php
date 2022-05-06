<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $modelUpload \admin\models\forms\UploadImagesForm */
/* @var $form yii\widgets\ActiveForm */
/* @var array $categoriesTitles */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if (!empty($model->image_url)) :?>
        <img src="<?= $model->image_url; ?>" alt="category-image" class="img-thumbnail"
             style="width: 150px; height: 150px; border-radius: 50%">
    <?php endif;?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoriesTitles)->label('Category') ?>

    <?= $form->field($modelUpload, 'image')->fileInput()->label('Product image') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reservation */
/* @var $form yii\widgets\ActiveForm */
/* @var $tableIds array */

$isActiveArray = ['No', 'Yes'];
?>

<div class="reservation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'table_id')->dropDownList($tableIds, ['disabled' => 'disabled']) ?>

    <?= $form->field($model, 'reserved_from')->textInput(['disabled' => 'disabled']) ?>

    <?= $form->field($model, 'reserved_to')->textInput(['disabled' => 'disabled']) ?>

    <?= $form->field($model, 'reserver_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reserver_phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reserver_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visitors_count')->textInput(['disabled' => 'disabled']) ?>

    <?= $form->field($model, 'is_active')->dropDownList($isActiveArray, ['options' =>
        [array_search($model->is_active, $isActiveArray) => ['selected' => true]]]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

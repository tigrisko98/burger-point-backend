<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1><?= Html::encode($this->title) ?></h1>
                <p>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
            </div>
            <div class="col-md-2">
                <?php if (!empty($model->image_url)): ?>
                    <img src="<?= $model->image_url; ?>" alt="category-image" class="img-thumbnail"
                         style="width: 150px; height: 150px; border-radius: 50%">
                <?php endif; ?>
            </div>
        </div>
    </div>
    <br>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>

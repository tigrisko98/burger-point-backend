<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'class' => 'yii\widgets\LinkPager',
            'options' => ['class' => 'pagination'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledPageCssClass' => 'page-link disabled',
            'activePageCssClass' => 'page-item active'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Category $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]);
    ?>


</div>

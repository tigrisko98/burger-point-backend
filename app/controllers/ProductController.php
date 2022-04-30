<?php

namespace app\controllers;

use app\resources\Product;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

class ProductController extends ActiveController
{
    public $modelClass = Product::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete']);
        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            'searchModel' => \common\models\Product::className(),
        ];

        return ArrayHelper::merge($actions, [
            'index' => [
                'pagination' => [
                    'pageSize' => 10,
                ],
//                'sort' => [
//                    'defaultOrder' => [
//                        'created_at' => SORT_DESC,
//                    ],
//                ],
            ],
        ]);
    }
}
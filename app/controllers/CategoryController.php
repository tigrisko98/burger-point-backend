<?php

namespace app\controllers;

use app\resources\Category;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use function Symfony\Component\String\u;

class CategoryController extends ActiveController
{
    public $modelClass = Category::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete']);
        return $actions;
//        return ArrayHelper::merge(parent::actions(), [
//            'index' => [
//                'pagination' => [
//                    'pageSize' => 10,
//                ],
//                'sort' => [
//                    'defaultOrder' => [
//                        'created_at' => SORT_DESC,
//                    ],
//                ],
//            ],
//        ]);
    }
}
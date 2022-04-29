<?php

namespace app\controllers;

use app\resources\Product;
use yii\rest\ActiveController;

class ProductController extends ActiveController
{
    public $modelClass = Product::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }
}
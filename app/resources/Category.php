<?php

namespace app\resources;


class Category extends \common\models\Category
{
    public function extraFields()
    {
        return ['products'];
    }
}
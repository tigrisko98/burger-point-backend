<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@categoriesImagesFolder' => 'images/categories',
        '@productsImagesFolder' => 'images/products',
        '@aboutUsImagesFolder' => 'images/about-us',
        '@restaurantImagesFolder' => 'images/restaurant'
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];

<?php

namespace app\controllers;

use app\resources\Settings;
use yii\rest\ActiveController;

class SettingsController extends ActiveController
{
    public $modelClass = Settings::class;

    public function actions()
    {
        return [];
    }

    public function actionSettings()
    {
        $settings = Settings::find()
            ->select([
                'address', 'email', 'telegram_link', 'instagram_link', 'facebook_link', 'work_schedule', 'restaurant_name'
            ])->one();

        return $this->response->data = $settings;
    }

    public function actionAboutUs()
    {
        $aboutUs = Settings::find()
            ->select([
                'about_us_text', 'about_us_images_links'
            ])->one();

        return $this->response->data = $aboutUs;
    }

    public function actionContacts()
    {
        $contacts = Settings::find()->select('restaurant_images_links')->one();

        return $this->response->data = array_merge($this->actionSettings()->toArray(), $contacts->toArray());

    }

}
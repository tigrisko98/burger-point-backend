<?php

namespace console\controllers;

use Yii;
use admin\models\Admin;
use yii\console\Controller;
use yii\console\Response;

class AdminController extends Controller
{
    public function actionGenerate($password, Response $response)
    {
        $admin = new Admin();
        $admin->login = Yii::$app->security->generateRandomString();
        $admin->setPassword($password);
        $admin->generateAuthKey();
        $admin->save();

        return $this->stdout("login: $admin->login" . "\r\n" . "password: $password" . "\r\n");
    }
}

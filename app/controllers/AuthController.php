<?php

namespace app\controllers;

use app\models\VerifyEmailForm;
use Yii;
use app\models\SignupForm;
use yii\base\InvalidArgumentException;
use yii\rest\ActiveController;
use app\models\User;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class AuthController extends ActiveController
{
    public $modelClass = User::class;

    public function actions()
    {
        return [];
    }

    /**
     * Registers user
     *
     * @return yii\web\Response
     */

    public function actionRegister(Response $response)
    {
        $model = new SignupForm();
        $formData = Yii::$app->request->post();

        if ($model->load($formData, '') && $model->validate() && $model->signup()) {
            $response->statusCode = 201;
            $response->data = ['message' => 'success'];

        } else {
            $response->statusCode = 422;
            $response->data = ['errors' => [$model->getErrors()]];

        }
        return $response;
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }
}
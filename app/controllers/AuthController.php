<?php

namespace app\controllers;

use app\models\VerifyEmailForm;
use app\models\LoginForm;
use Yii;
use app\models\SignupForm;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use app\models\User;
use yii\web\BadRequestHttpException;
use yii\web\Request;
use yii\web\Response;

class AuthController extends ActiveController
{
    public $modelClass = User::class;

    public function actions()
    {
        return [];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['only'] = ['test'];
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class
        ];

        return $behaviors;
    }

    /**
     * Registers user
     *
     * @return yii\web\Response
     */

    public function actionRegister(Request $request, Response $response)
    {
        $model = new SignupForm();
        $formData = $request->post();

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
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token, Response $response)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            $response->statusCode = 200;
            $response->data = ['message' => 'Your email has been confirmed!', 'user' => $user];
            return $response;
        }

        $response->statusCode = 422;
        $response->data = ['type' => 'error', 'message' => 'Sorry, we are unable to verify your account with provided token.'];
        return $response;
    }

    /**
     * Logs in user
     *
     * @return yii\web\Response
     */
    public function actionLogin(Request $request, Response $response)
    {
        $model = new LoginForm();
        $formData = $request->post();

        if ($model->load($formData, '') && $model->login()) {
            $response->statusCode = 200;
            $response->data = ['message' => 'success', 'user' => $model->getUser()];

        } else {
            $response->statusCode = 422;
            $response->data = ['errors' => [$model->getErrors()]];

        }
        return $response;
    }

    /**
     * Logs out user
     *
     * @return yii\web\Response
     */
    public function actionLogout(Response $response)
    {
        $user = User::findOne(Yii::$app->user->id);

        if (!$user) {
            $response->statusCode = 400;
            $response->data = ['type' => 'error', 'message' => 'You are not logged in'];
            return $response;
        }

        Yii::$app->user->logout();

        $user->access_token = '';
        $user->update();

        $response->statusCode = 200;
        $response->data = ['message' => 'success'];
        return $response;
    }

}
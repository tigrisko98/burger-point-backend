<?php

namespace app\controllers;

use app\models\forms\CreateReservationForm;
use app\models\forms\EnabledTablesForm;
use app\resources\Reservation;
use yii\rest\ActiveController;

class ReservationController extends ActiveController
{
    public $modelClass = Reservation::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionCreate()
    {
        $model = new CreateReservationForm();
        $formData = $this->request->post();

        if ($this->request->isPost) {
            if ($model->load($formData, '') && $reservation = $model->reserve()) {
                return $this->response->data = $reservation;
            }
        }

        $this->response->statusCode = 422;
        return $this->response->data = ['type' => 'error', 'message' => 'You cannot reserve this table'];
    }

    public function actionEnabledTables()
    {
        $model = new EnabledTablesForm();
        $response = $this->response;

        if ($model->load($this->request->get(), '') && $model->validate()){
            return $response->data = $model->enabledTables();
        }
        return $response->data = ['type' => 'validation', 'message' => $model->getErrors()];
    }
}
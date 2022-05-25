<?php

namespace console\controllers;

use common\models\Reservation;
use yii\console\Controller;

class ReservationsController extends Controller
{
    public function actionDeactivate()
    {
        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd = date('Y-m-d 23:59:59');
        $reservations = Reservation::find()->where(['is_active' => 1])->andWhere(['>=', 'reserved_from', $todayStart])
            ->andWhere(['<=', 'reserved_to', $todayEnd])->all();

        foreach ($reservations as $reservation) {
            $reservation->is_active = 0;
            $reservation->save();
        }

        return $this->stdout("Success" . "\r\n");
    }
}
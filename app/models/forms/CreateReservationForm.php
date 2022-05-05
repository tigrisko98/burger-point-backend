<?php

namespace app\models\forms;

use app\resources\Reservation;
use common\models\Table;
use yii\base\Model;

class CreateReservationForm extends Model
{
    public $table_id;
    public $reserved_from;
    public $reserved_to;
    public $reserver_name;
    public $reserver_phone_number;
    public $reserver_email;
    public $visitors_count;

    public function rules()
    {
        return [
            ['table_id', 'validateTable', 'message' => 'Table is already reserved.']
        ];
    }

    public function enabledTables()
    {
        $reservations = Reservation::find()->select(['table_id', 'reserved_from', 'reserved_to'])->asArray()->all();

        $enabledTablesIds = [];
        foreach ($reservations as $reservation) {
            if (in_array($reservation['table_id'], $enabledTablesIds)) {
                continue;
            }
            if ($this->reserved_from < $reservation['reserved_from'] && $this->reserved_to < $reservation['reserved_to']
                && $this->visitors_count <= Table::find()->select('seats')->where(['id' => $this->table_id])->column()) {
                $enabledTablesIds[] = $reservation['table_id'];
            }
        }

        return $enabledTablesIds;
    }

    public function validateTable()
    {
        return !in_array($this->table_id, $this->enabledTables());


    }

    public function reserve()
    {
        if (!$this->validate()) {
            return null;
        }

        $reservation = new Reservation();
        $reservation->table_id = $this->table_id;
        $reservation->reserved_from = $this->reserved_from;
        $reservation->reserved_to = $this->reserved_to;
        $reservation->reserver_name = $this->reserver_name;
        $reservation->reserver_phone_number = $this->reserver_phone_number;
        $reservation->reserver_email = $this->reserver_email;
        $reservation->save();

        return $reservation;
    }
}
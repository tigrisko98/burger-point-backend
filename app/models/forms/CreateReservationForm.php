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

    public function validateTable()
    {
        return !in_array($this->table_id, Table::enabledTables($this->reserved_from, $this->reserved_to, $this->visitors_count));
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
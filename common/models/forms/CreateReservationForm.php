<?php

namespace common\models\forms;

use common\models\Reservation;
use common\models\Table;
use yii\base\Model;

class CreateReservationForm extends Model
{
    use \common\components\ValidateDateTrait;

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
            [['table_id', 'reserved_from', 'reserved_to', 'reserver_name', 'reserver_phone_number', 'visitors_count'], 'required'],
            ['visitors_count', 'validateVisitorsCount'],
            ['table_id', 'validateTable'],
            ['reserved_from', 'compare', 'compareAttribute' => 'reserved_to', 'operator' => '<', 'enableClientValidation' => false],
            [['reserved_from', 'reserved_to'], 'validateDate'],
            [['reserver_email'], 'email']
        ];
    }

    public function validateTable($attribute)
    {
        if (!in_array($this->table_id, Table::enabledTables($this->reserved_from, $this->reserved_to, $this->visitors_count))) {
            $this->addError($attribute, 'You cannot reserve this table');
        }
    }

    public function validateVisitorsCount($attribute)
    {
        $seats = Table::findOne(['id' => $this->table_id])->seats;

        if ($this->visitors_count > $seats) {
            $this->addError($attribute, "Visitors count should be equal or less than $seats");
        }
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
        $reservation->visitors_count = $this->visitors_count;
        $reservation->is_active = 1;
       $reservation->save();

        return $reservation;
    }
}
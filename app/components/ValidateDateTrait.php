<?php

namespace app\components;

use DateTime;

trait ValidateDateTrait
{
    public function validateDate($attribute)
    {
        $format = 'Y-d-m H:i:s';
        $d1 = DateTime::createFromFormat($format, $this->reserved_from);
        $d2 = DateTime::createFromFormat($format, $this->reserved_to);

        if (!($d1 && $d1->format($format) == $this->reserved_from) || !($d2 && $d2->format($format) == $this->reserved_to)
            || $this->reserved_from <= date('Y-d-m H:i:s') || $this->reserved_to <= date('Y-d-m H:i:s')) {
            $this->addError($attribute, 'Invalid date');
        }
    }
}
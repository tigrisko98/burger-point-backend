<?php

namespace app\models\forms;

use common\models\Table;
use yii\base\Model;

class EnabledTablesForm extends Model
{
    public $reservedFrom;
    public $reservedTo;
    public $visitorsCount;

    public function rules()
    {
        return [
            [['reservedFrom', 'reservedTo', 'visitorsCount'], 'required'],
            [['reservedFrom', 'reservedTo'], 'datetime'],
            [['visitorsCount'], 'integer']
        ];
    }

    public function enabledTables(): array
    {
        return Table::enabledTables($this->reservedFrom, $this->reservedTo, $this->visitorsCount);
    }
}
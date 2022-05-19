<?php

namespace app\models\forms;

use common\models\Table;
use DateTime;
use yii\base\Model;

class EnabledTablesForm extends Model
{
    use \common\components\ValidateDateTrait;

    public $reserved_from;
    public $reserved_to;
    public $visitors_count;

    public function rules()
    {
        return [
            [['reserved_from', 'reserved_to', 'visitors_count'], 'required'],
            ['reserved_from', 'compare', 'compareAttribute' => 'reserved_to', 'operator' => '<', 'enableClientValidation' => false],
            [['reserved_from', 'reserved_to'], 'validateDate'],
            [['visitors_count'], 'integer']
        ];
    }

    public function enabledTables(): array
    {
        return Table::enabledTables($this->reserved_from, $this->reserved_to, $this->visitors_count);
    }
}
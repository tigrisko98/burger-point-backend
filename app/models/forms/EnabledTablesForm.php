<?php

namespace app\models\forms;

use common\models\Table;
use yii\base\Model;

class EnabledTablesForm extends Model
{
    public $reserved_from;
    public $reserved_to;
    public $visitors_count;

    public function rules()
    {
        return [
            [['reserved_from', 'reserved_to', 'visitors_count'], 'required'],
            [['reserved_from', 'reserved_to'], 'datetime'],
            [['visitors_count'], 'integer']
        ];
    }

    public function enabledTables(): array
    {
        return Table::enabledTables($this->reserved_from, $this->reserved_to, $this->visitors_count);
    }
}
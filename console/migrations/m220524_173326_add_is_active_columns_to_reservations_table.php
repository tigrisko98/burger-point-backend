<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%reservations}}`.
 */
class m220524_173326_add_is_active_columns_to_reservations_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%reservations}}', 'is_active', $this->boolean()->notNull()->defaultValue(1)
            ->after('visitors_count'));
    }

    public function down()
    {
        $this->dropColumn('{{%reservations}}', 'is_active');
    }
}

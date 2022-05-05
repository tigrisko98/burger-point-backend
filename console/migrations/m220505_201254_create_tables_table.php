<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tables}}`.
 */
class m220505_201254_create_tables_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tables}}', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->notNull()->unique(),
            'seats' => $this->integer()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%tables}}');
    }
}

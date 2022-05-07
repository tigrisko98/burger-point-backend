<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reservations}}`.
 */
class m220505_201309_create_reservations_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%reservations}}', [
            'id' => $this->primaryKey(),
            'table_id' => $this->integer()->notNull(),
            'reserved_from' => $this->dateTime()->notNull(),
            'reserved_to' => $this->dateTime()->notNull(),
            'reserver_name' => $this->string()->notNull(),
            'reserver_phone_number' => $this->string()->notNull(),
            'reserver_email' => $this->string(),
            'visitors_count' => $this->integer()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('FK_reservations_tables_table_id', '{{%reservations}}', 'table_id', '{{%tables}}', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('FK_reservations_tables_table_id', '{{%reservations}}');
        $this->dropTable('{{%reservations}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admins}}`.
 */
class m220427_112505_create_admins_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admins}}', [
            'id' => $this->primaryKey(),
            'auth_key' => $this->string(32)->notNull(),
            'login' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%admins}}');
    }
}

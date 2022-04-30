<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m220430_125626_create_settings_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'address' => $this->string()->notNull()->defaultValue(''),
            'phone_number' => $this->string()->notNull()->defaultValue(''),
            'email' => $this->string()->notNull()->defaultValue(''),
            'telegram_link' => $this->string()->notNull()->defaultValue(''),
            'instagram_link' => $this->string()->notNull()->defaultValue(''),
            'facebook_link' => $this->string()->notNull()->defaultValue(''),
            'work_schedule' => $this->string()->notNull()->defaultValue('Пн-Пт 9:00-20:00' . "\r\n" . 'Cб-Нд 9:00-22:00'),
            'restaurant_images_links' => $this->text()->notNull(),
            'about_us_text' => $this->text(),
            'about_us_images_links' => $this->text()->notNull(),
            'restaurant_name' => $this->string()->notNull()->defaultValue('Burger-point'),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('{{%settings}}', [
            'about_us_text' => 'About us text',
            'restaurant_images_links' => '',
            'about_us_images_links' => '',
            'created_at' => 'UNIX_TIMESTAMP()',
            'updated_at' => 'UNIX_TIMESTAMP()'
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%settings}}');
    }
}

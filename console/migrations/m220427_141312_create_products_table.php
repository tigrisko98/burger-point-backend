<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m220427_141312_create_products_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'price' => $this->float()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'image' => $this->string()->notNull()->defaultValue('category_default.png'),
            'image_url' => $this->string()->notNull()->defaultValue(''),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('FK_products_categories_category_id', '{{%products}}', 'category_id', '{{%categories}}', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('FK_products_categories_category_id', '{{%products}}');
        $this->dropTable('{{%products}}');
    }
}

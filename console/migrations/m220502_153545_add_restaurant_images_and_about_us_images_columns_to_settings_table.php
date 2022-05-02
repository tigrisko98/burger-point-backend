<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%settings}}`.
 */
class m220502_153545_add_restaurant_images_and_about_us_images_columns_to_settings_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%settings}}', 'restaurant_images', $this->text()->after('work_schedule'));
        $this->addColumn('{{%settings}}', 'about_us_images', $this->text()->after('about_us_text'));

        $this->update('{{%settings}}', [
            'restaurant_images' => '',
            'about_us_images' => ''
        ], [
            'id' => 1
        ]);
    }

    public function down()
    {
        $this->dropColumn('{{%settings}}', 'restaurant_images');
        $this->dropColumn('{{%settings}}', 'about_us_images');
    }
}

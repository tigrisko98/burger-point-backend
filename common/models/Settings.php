<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $address
 * @property string $phone_number
 * @property string $email
 * @property string $telegram_link
 * @property string $instagram_link
 * @property string $facebook_link
 * @property string $work_schedule
 * @property string $restaurant_images_links
 * @property string|null $about_us_text
 * @property string $about_us_images_links
 * @property string $restaurant_name
 * @property int $created_at
 * @property int $updated_at
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'phone_number', 'email', 'telegram_link', 'instagram_link', 'facebook_link', 'restaurant_name'], 'required'],
            [['address', 'phone_number', 'email', 'telegram_link', 'instagram_link', 'facebook_link', 'work_schedule', 'restaurant_name'], 'string', 'max' => 255],
            [['telegram_link', 'instagram_link', 'facebook_link'], 'url'],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'phone_number' => 'Phone Number',
            'email' => 'Email',
            'telegram_link' => 'Telegram Link',
            'instagram_link' => 'Instagram Link',
            'facebook_link' => 'Facebook Link',
            'work_schedule' => 'Work Schedule',
            'restaurant_images_links' => 'Restaurant Images Links',
            'about_us_text' => 'About Us Text',
            'about_us_images_links' => 'About Us Images Links',
            'restaurant_name' => 'Restaurant Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
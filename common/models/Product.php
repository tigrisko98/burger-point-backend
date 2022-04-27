<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $title
 * @property float $price
 * @property int $category_id
 * @property string $image
 * @property string $image_url
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Category $category
 */
class Product extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'price', 'category_id', 'image_url', 'created_at', 'updated_at'], 'required'],
            [['price'], 'number'],
            [['category_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'image', 'image_url'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
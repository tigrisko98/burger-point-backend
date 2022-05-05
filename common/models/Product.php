<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
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
 * @property Category $category
 */
class Product extends ActiveRecord
{
    use \admin\components\timestamp\UnixTimestampToDateTrait;

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
            [['title', 'price', 'category_id'], 'required'],
            [['price'], 'number'],
            [['category_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['title'], 'trim'],
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

    public static function deleteProductsByCategoryId($id)
    {
        return Product::deleteAll(['category_id' => $id]);
    }
}

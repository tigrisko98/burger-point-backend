<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Category model
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $image_url
 * @property integer $created_at
 * @property integer $updated_at
 */
class Category extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%categories}}';
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
            [['title', 'image_url', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'image', 'image_url'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ];
    }


    /**
     * Finds category by title
     *
     * @param string $title
     * @return static|null
     */
    public static function findByTitle($title)
    {
        return static::findOne(['title' => $title]);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }
}

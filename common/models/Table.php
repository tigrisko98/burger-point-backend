<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tables".
 *
 * @property int $id
 * @property int $number
 * @property int $seats
 * @property int $created_at
 * @property int $updated_at
 *
 */

class Table extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tables}}';
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
            [['number', 'seats'], 'required'],
            [['number', 'seats', 'created_at', 'updated_at'], 'integer'],
            [['seats'], 'min' => 1, 'max' => 6],
            [['number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'seats' => 'Seats',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
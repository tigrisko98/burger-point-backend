<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "reservations".
 *
 * @property int $id
 * @property int $table_id
 * @property string $reserved_from
 * @property string $reserved_to
 * @property string $reserver_name
 * @property int $reserver_phone_number
 * @property string|null $reserver_email
 * @property int $visitors_count
 * @property boolean $is_active
 * @property int $created_at
 * @property int $updated_at
 * @property Table $table
 */
class Reservation extends \yii\db\ActiveRecord
{
    use \admin\components\timestamp\UnixTimestampToDateTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%reservations}}';
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
            [['table_id', 'reserved_from', 'reserved_to', 'reserver_name', 'reserver_phone_number', 'visitors_count'], 'required'],
            [['table_id', 'reserver_phone_number', 'visitors_count'], 'integer'],
            [['reserved_from', 'reserved_to'], 'string'],
            [['reserver_name'], 'string', 'max' => 255],
            [['reserver_email'], 'email'],
            [['table_id'], 'exist', 'skipOnError' => true, 'targetClass' => Table::className(), 'targetAttribute' => ['table_id' => 'id']],
            [['is_active'], 'required'],
            [['is_active'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_id' => 'Table ID',
            'reserved_from' => 'Reserved From',
            'reserved_to' => 'Reserved To',
            'reserver_name' => 'Reserver Name',
            'reserver_phone_number' => 'Reserver Phone Number',
            'reserver_email' => 'Reserver Email',
            'visitors_count' => 'Visitors Count',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Table]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTable()
    {
        return $this->hasOne(Table::className(), ['id' => 'table_id']);
    }
}
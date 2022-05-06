<?php

namespace common\models;

use app\resources\Reservation;
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

    public static function enabledTables($reservedFrom, $reservedTo, $visitorsCount): array
    {
        $tableIds = static::find()->select('id')->asArray()->all();

        foreach ($tableIds as $id) {
            $reservations = Reservation::find()
                ->select(['table_id', 'reserved_from', 'reserved_to'])->where(['table_id' => $id])->asArray()->all();
            $enabledTablesIds = [];

            if (!empty($reservations)) {
                foreach ($reservations as $reservation) {
                    if (in_array($reservation['table_id'], $enabledTablesIds)) {
                        continue;
                    }
                    if ($reservedFrom < $reservation['reserved_from'] && $reservedTo < $reservation['reserved_to']
                        && $visitorsCount <= Table::find()->select('seats')->where(['id' => $reservation['table_id']])->column()) {
                        $enabledTablesIds[] = $reservation['table_id'];
                    }
                }
            } else {
                $enabledTablesIds[] = $id;
            }
        }

        return $enabledTablesIds;
    }
}
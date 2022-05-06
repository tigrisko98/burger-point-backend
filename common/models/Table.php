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
    use \admin\components\timestamp\UnixTimestampToDateTrait;

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
            [['number'], 'integer'],
            [['seats'], 'integer', 'min' => 1, 'max' => 6],
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
        $tableIds = static::find()->select('id')->where(['>=', 'seats', $visitorsCount])->column();
        $enabledTablesIds = [];

        foreach ($tableIds as $id) {
            $reservations = Reservation::find()
                ->select(['table_id', 'reserved_from', 'reserved_to'])->where(['table_id' => $id])->asArray()->all();

            if (!empty($reservations)) {
                foreach ($reservations as $reservation) {
                    if (in_array($reservation['table_id'], $enabledTablesIds)) {
                        continue;
                    }
                    if ($reservedFrom < $reservation['reserved_from'] && $reservedTo < $reservation['reserved_to']) {
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
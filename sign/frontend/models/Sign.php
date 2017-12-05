<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sign".
 *
 * @property integer $id
 * @property integer $date_time
 * @property integer $user_id
 * @property integer $days
 * @property integer $maney
 * @property integer $day
 */
class Sign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_time', 'user_id', 'days', 'maney', 'day'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_time' => 'Date Time',
            'user_id' => 'User ID',
            'days' => 'Days',
            'maney' => 'Maney',
            'day' => 'Day',
        ];
    }
}

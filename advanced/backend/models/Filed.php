<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "filed".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $type
 * @property string $is_choise
 * @property string $rule
 * @property string $begin
 * @property string $stop
 */
class Filed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'filed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title', 'type', 'is_choise', 'rule', 'begin', 'stop'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'title' => 'Title',
            'type' => 'Type',
            'is_choise' => 'Is Choise',
            'rule' => 'Rule',
            'begin' => 'Begin',
            'stop' => 'Stop',
        ];
    }
}

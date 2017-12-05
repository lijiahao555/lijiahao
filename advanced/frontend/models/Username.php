<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "username".
 *
 * @property integer $id
 * @property string $name
 * @property string $pwd
 * @property string $tel
 * @property string $content
 */
class Username extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'username';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'pwd', 'tel', 'content'], 'string', 'max' => 255],
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
            'pwd' => 'Pwd',
            'tel' => 'Tel',
            'content' => 'Content',
        ];
    }
}

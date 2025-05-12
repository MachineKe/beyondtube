<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%subscriber}}".
 *
 * @property int $id
 */
class Subscriber extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%subscriber}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'channel_id'], 'required'],
            [['user_id', 'channel_id', 'created_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'channel_id' => 'Channel ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SubscriberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubscriberQuery(get_called_class());
    }

}

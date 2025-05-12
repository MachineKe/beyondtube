<?php

use yii\db\Migration;

/**
 * Handles adding column `user_id` to table `{{%subscriber}}`.
 */
class m250512_140000_add_user_id_to_subscriber_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%subscriber}}', 'user_id', $this->integer()->notNull());
        $this->createIndex(
            'idx-subscriber-user_id',
            '{{%subscriber}}',
            'user_id'
        );
        $this->addForeignKey(
            'fk-subscriber-user_id-user-id',
            '{{%subscriber}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
        // Optional: unique index to prevent duplicate subscriptions
        $this->createIndex(
            'idx-subscriber-channel_id-user_id-unique',
            '{{%subscriber}}',
            ['channel_id', 'user_id'],
            true
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-subscriber-user_id-user-id', '{{%subscriber}}');
        $this->dropIndex('idx-subscriber-user_id', '{{%subscriber}}');
        $this->dropIndex('idx-subscriber-channel_id-user_id-unique', '{{%subscriber}}');
        $this->dropColumn('{{%subscriber}}', 'user_id');
    }
}

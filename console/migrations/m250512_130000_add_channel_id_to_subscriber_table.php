<?php

use yii\db\Migration;

/**
 * Handles adding column `channel_id` to table `{{%subscriber}}`.
 */
class m250512_130000_add_channel_id_to_subscriber_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%subscriber}}', 'channel_id', $this->integer()->notNull());
        $this->createIndex(
            'idx-subscriber-channel_id',
            '{{%subscriber}}',
            'channel_id'
        );
        $this->addForeignKey(
            'fk-subscriber-channel_id-user-id',
            '{{%subscriber}}',
            'channel_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-subscriber-channel_id-user-id', '{{%subscriber}}');
        $this->dropIndex('idx-subscriber-channel_id', '{{%subscriber}}');
        $this->dropColumn('{{%subscriber}}', 'channel_id');
    }
}

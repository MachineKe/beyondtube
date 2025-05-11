<?php

use yii\db\Migration;

/**
 * Handles adding created_at column to table `{{%video}}`.
 */
class m250511_111300_add_created_at_to_video_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%video}}', 'created_at', $this->integer()->null()->after('status'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%video}}', 'created_at');
    }
}

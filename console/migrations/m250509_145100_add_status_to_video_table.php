<?php

use yii\db\Migration;

/**
 * Handles adding status to table `{{%video}}`.
 */
class m250509_145100_add_status_to_video_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%video}}', 'status', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%video}}', 'status');
    }
}

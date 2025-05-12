<?php

use yii\db\Migration;

/**
 * Handles adding column `created_at` to table `{{%subscriber}}`.
 */
class m250512_150000_add_created_at_to_subscriber_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%subscriber}}', 'created_at', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%subscriber}}', 'created_at');
    }
}

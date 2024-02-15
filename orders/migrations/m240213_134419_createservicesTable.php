<?php

namespace orders\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%services}}`.
 */
class m240213_134419_createservicesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('services', [
            'id' => $this->primaryKey(),
            'name' => $this->string(300),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('services');
    }
}

<?php

namespace orders\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m240213_134430_createOrdersTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'link' => $this->string(300),
            'quantity' => $this->integer(),
            'service_id' => $this->integer(),
            'status' => $this->tinyInteger(),
            'created_at' => $this->integer(),
            'mode' => $this->tinyInteger(),

        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('orders');
    }
}

<?php

use yii\db\Migration;

/**
 * Class m240215_062553_insert_orders_table
 */
class m240215_062553_insert_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i <= 10000; $i++) {
            $this->insert('orders', [
                'user_id' => rand(1, 100),
                'link' => $faker->url,
                'quantity' => $faker->numberBetween(1, 15000),
                'service_id' => rand(1, 17),
                'status' => rand(0, 4),
                'created_at' => $faker->numberBetween(1600000000, 1707979332),
                'mode' => rand(0, 1),
            ]);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240215_062553_insert_orders_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240215_062553_insert_orders_table cannot be reverted.\n";

        return false;
    }
    */
}

<?php

namespace orders\migrations;

use Faker;
use yii\db\Migration;

/**
 * Class m240215_062315_insert_users_table
 */
class m240215_062315_insert_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i <= 100; $i++) {
            $this->insert('users', ['first_name' => $faker->firstName, 'last_name' => $faker->lastName]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240215_062315_insert_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240215_062315_insert_users_table cannot be reverted.\n";

        return false;
    }
    */
}

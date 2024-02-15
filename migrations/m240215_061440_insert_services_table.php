<?php

use yii\db\Migration;

/**
 * Class m240215_061440_insert_services_table
 */
class m240215_061440_insert_services_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('services', ['name' => 'Likes']);
        $this->insert('services', ['name' => 'Followers']);
        $this->insert('services', ['name' => 'Views']);
        $this->insert('services', ['name' => 'Tweets']);
        $this->insert('services', ['name' => 'Retweets']);
        $this->insert('services', ['name' => 'Comments']);
        $this->insert('services', ['name' => 'Custom comments']);
        $this->insert('services', ['name' => 'Page Likes']);
        $this->insert('services', ['name' => 'Post Likes']);
        $this->insert('services', ['name' => 'Friends']);
        $this->insert('services', ['name' => 'SEO']);
        $this->insert('services', ['name' => 'Mentions']);
        $this->insert('services', ['name' => 'Mentions with Hashtags']);
        $this->insert('services', ['name' => 'Mentions Custom List']);
        $this->insert('services', ['name' => 'Mentions Hashtag']);
        $this->insert('services', ['name' => 'Mentions User Followers']);
        $this->insert('services', ['name' => 'Mentions Media Likers']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240215_061440_insert_services_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240215_061440_insert_services_table cannot be reverted.\n";

        return false;
    }
    */
}

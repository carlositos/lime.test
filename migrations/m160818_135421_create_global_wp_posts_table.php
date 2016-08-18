<?php

use yii\db\Migration;

/**
 * Handles the creation for table `global_wp_posts`.
 */
class m160818_135421_create_global_wp_posts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('global_wp_posts', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(11),
            'source_id' => $this->integer(11),
            'link' => $this->string(255),
            'creator' => $this->string(255),
            'post_date' => $this->dateTime(),
            'post_date_gmt' => $this->dateTime(),
            'post_content' => $this->text(),
            'post_title' => $this->text(),
            'post_excerpt' => $this->text(),
            'post_status' => $this->string(20),
            'comment_status' => $this->string(20),
            'ping_status' => $this->string(20),
            'post_password' => $this->string(20),
            'post_name' => $this->string(200),
            'post_parent' => $this->integer(11),
            'guid' => $this->string(255),
            'menu_order' => $this->integer(11),
            'post_type' => $this->string(20)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('global_wp_posts');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation for table `global_wp_postmeta`.
 */
class m160818_135901_create_global_wp_postmeta_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('global_wp_postmeta', [
            'id' => $this->primaryKey(),
            'source_id' => $this->integer(11),
            'meta_id' => $this->integer(11),
            'post_id' => $this->integer(11),
            'meta_key' => $this->string(255),
            'meta_value' => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('global_wp_postmeta');
    }
}

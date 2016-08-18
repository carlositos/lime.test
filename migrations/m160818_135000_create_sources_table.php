<?php

use yii\db\Migration;

/**
 * Handles the creation for table `sources`.
 */
class m160818_135000_create_sources_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sources', [
            'id' => $this->primaryKey(),
            'filename' => $this->string(255),
            'siteurl' => $this->string(255),
            'created_at' => $this->integer(11),
        ]);
        
        $this->dropTable('sources');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sources');
    }
}

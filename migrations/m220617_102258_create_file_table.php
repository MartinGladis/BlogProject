<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%file}}`.
 */
class m220617_102258_create_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'filename' => $this->string()->notNull(),
            'mime_type' => $this->string()
        ]);

        $this->addForeignKey(
            'FK_file_post',
            'tbl_file',
            'post_id',
            'tbl_post',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%file}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m220613_102708_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'topic' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'user_id' => $this->integer(),
            'create_at' => $this->timestamp()->notNull(),
            'update_at' => $this->datetime()
        ]);

        $this->addForeignKey(
            'FK_post_user',
            'tbl_post',
            'user_id',
            'tbl_user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post}}');
    }
}

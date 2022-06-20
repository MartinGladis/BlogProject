<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m220613_100356_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'surname' => $this->string(255)->notNull(),
            'username' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'auth_key' => $this->string(255)->notNull(),
            'birthdate' => $this->date()->notNull(),
            'street_name' => $this->string(255),
            'number' => $this->string(10),
            'postcode' => $this->string(6),
            'email' => $this->string(255)->notNull()->unique(),
            'pesel' => $this->string(11),
            'registered_at' => $this->timestamp()->notNull(),
            'last_login' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}

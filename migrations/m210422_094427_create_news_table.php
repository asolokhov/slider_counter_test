<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m210422_094427_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
			'title' => $this->char(255)->notNull(),
			'content' => $this->text()->notNull(),
			'image' => $this->char(255)->defaultValue(null),
			'slug' => $this->char(255)->notNull(),
			'created_at' => $this->integer()->defaultValue(null),
			'updated_at' => $this->integer()->defaultValue(null)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}

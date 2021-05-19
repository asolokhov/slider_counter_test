<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%statistic}}`.
 */
class m210422_104913_create_statistic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%statistic}}', [
            'id' => $this->primaryKey(),
			'news_id' => $this->integer()->notNull(),
			'view_count' => $this->integer()->defaultValue(0),
            'session_id' =>  $this->char(255)->defaultValue(null),
			'created_at' => $this->integer()->defaultValue(null),
			'updated_at' => $this->integer()->defaultValue(null)
        ]);
		
		$this->addForeignKey(
            '{{%statistic_news_id_foreign}}',
            '{{%statistic}}',
            'news_id',
            '{{%news}}',
            'id',
            'CASCADE',
			'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%statistic}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tbfundstock`.
 */
class m180517_074158_create_tbfundstock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbfundstock', [
            'fundstock_id' => $this->primaryKey(),
            'fund_id' => $this->integer()->notNull(),
            'datadate' => $this->date()->notNull(),
            'dataunit' => $this->double(),
            'dataprice' => $this->double(),
        ]);
        
        $this->createIndex(
            'Index 2',
            'tbfundstock',
            ['fund_id','datadate'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
         $this->dropIndex(
            'Index 2',
            'tbfunddata'
        );
        $this->dropTable('tbfundstock');
    }
}

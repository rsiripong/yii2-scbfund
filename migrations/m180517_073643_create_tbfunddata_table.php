<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tbfunddata`.
 */
class m180517_073643_create_tbfunddata_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbfunddata', [
            'funddata_id' => $this->primaryKey(),
            'fund_id' => $this->integer()->notNull(),
            'datadate' => $this->date()->notNull(),
            'dataprice' => $this->double(),
            'datadiff' => $this->double(),
            'datapecen' => $this->double(),
            'datasummary' => $this->double(),
            'datatrans' => $this->double(),
        ]);
        
        $this->createIndex(
            'Index 2',
            'tbfunddata',
            ['fund_id','datadate'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /*
        $this->dropIndex(
           'Index 2',
            'tbfunddata'
        );
         * 
         */
        $this->dropTable('tbfunddata');
    }
}

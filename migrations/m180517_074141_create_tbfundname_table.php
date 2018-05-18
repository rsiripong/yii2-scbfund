<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tbfundname`.
 */
class m180517_074141_create_tbfundname_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbfundname', [
            'fund_id' => $this->primaryKey(),
            'fundname' => $this->string(50)->notNull(),
            'funddesc' => $this->string(255),
        ]);
        
         $this->createIndex(
            'Index 2',
            'tbfundname',
            'fundname',
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
            'tbfundname'
        );
        $this->dropTable('tbfundname');
    }
}

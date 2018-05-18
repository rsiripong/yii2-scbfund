<?php

use yii\db\Migration;

/**
 * Class m180517_091044_add_lastdatadate_to_tbfundname
 */
class m180517_091044_add_lastdatadate_to_tbfundname extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->addColumn('tbfundname', 'lastdatadate', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        $this->dropColumn('tbfundname', 'lastdatadate');
        //echo "m180517_091044_add_lastdatadate_to_tbfundname cannot be reverted.\n";

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180517_091044_add_lastdatadate_to_tbfundname cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m190303_114935_add_date_to
 */
class m190303_114935_add_date_to extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comment','date',$this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropColumn('comment','date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190303_114935_add_date_to cannot be reverted.\n";

        return false;
    }
    */
}

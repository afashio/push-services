<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service}}`.
 */
class m200722_151959_create_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(\afashio\services\models\Service::tableName(), [
            'id' => $this->primaryKey(),
            'status' => $this->integer(1),
            'is_main' => $this->integer(1)->defaultValue(0),
            'slug' => $this->string(250)->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(\afashio\services\models\Service::tableName());
    }
}

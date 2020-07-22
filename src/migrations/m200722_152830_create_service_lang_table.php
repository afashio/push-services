<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_lang}}`.
 */
class m200722_152830_create_service_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(\afashio\services\models\ServiceLang::tableName(), [
            'id' => $this->primaryKey(),
            'service_id' => $this->integer(),
            'language' => $this->string(6),
            'title' => $this->string(250),
            'text' => $this->text(),
        ]);

        // creates index for column `service_id`
        $this->createIndex(
            '{{%idx-service_lang-service_id}}',
            '{{%service_lang}}',
            'service_id'
        );

        // add foreign key for table `{{%service}}`
        $this->addForeignKey(
            '{{%fk-service_lang-service_id}}',
            '{{%service_lang}}',
            'service_id',
            '{{%service}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%service}}`
        $this->dropForeignKey(
            '{{%fk-service_lang-service_id}}',
            '{{%service_lang}}'
        );

        // drops index for column `service_id`
        $this->dropIndex(
            '{{%idx-service_lang-service_id}}',
            '{{%service_lang}}'
        );

        $this->dropTable(\afashio\services\models\ServiceLang::tableName());
    }
}

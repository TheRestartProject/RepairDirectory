<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20210510104039 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSQL("ALTER TABLE `businesses` ADD `hide_reason` ENUM('Closed temporarily','Closed permanently','Doesn''t meet quality criteria','Asked to be removed','Other') NULL DEFAULT NULL AFTER `publishing_status`;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSQL("ALTER TABLE `businesses` DROP COLUMN hide_reason;");
    }
}

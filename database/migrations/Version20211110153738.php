<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20211110153738 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSQL("ALTER TABLE `businesses` CHANGE `hide_reason` `hide_reason` ENUM('Closed temporarily','Closed permanently','Doesn''t meet quality criteria','Asked to be removed','Other','Not in communication') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSQL("ALTER TABLE `businesses` CHANGE `hide_reason` `hide_reason` ENUM('Closed temporarily','Closed permanently','Doesn''t meet quality criteria','Asked to be removed','Other') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;;");
    }
}

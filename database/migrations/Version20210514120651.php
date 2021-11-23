<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20210514120651 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSQL("ALTER TABLE `businesses` MODIFY community_endorsement LONGTEXT, MODIFY notes LONGTEXT, MODIFY qualifications LONGTEXT;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSQL("ALTER TABLE `businesses` MODIFY community_endorsement VARCHAR(255), MODIFY notes VARCHAR(255), MODIFY qualifications VARCHAR(255);");
    }
}

<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170822151244 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users CHANGE recovery recovery VARCHAR(45) DEFAULT NULL, CHANGE recovery_expires recovery_expires DATETIME DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE modified_at modified_at DATETIME DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users CHANGE recovery recovery VARCHAR(45) NOT NULL COLLATE utf8_unicode_ci, CHANGE recovery_expires recovery_expires DATETIME NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE modified_at modified_at DATETIME NOT NULL');
    }
}

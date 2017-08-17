<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170817111739 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE businesses ADD authorised_brands LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD community_endorsement VARCHAR(255) DEFAULT NULL, ADD notes VARCHAR(255) DEFAULT NULL, DROP authorised, CHANGE products_repaired products_repaired LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE businesses ADD authorised TINYINT(1) NOT NULL, DROP authorised_brands, DROP community_endorsement, DROP notes, CHANGE products_repaired products_repaired LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\'');
    }
}

<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170803165548 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE businesses (uid INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postcode VARCHAR(255) NOT NULL, geolocation POINT DEFAULT NULL, description LONGTEXT NOT NULL, landline VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, local_area VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, products_repaired LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', authorised TINYINT(1) NOT NULL, qualifications VARCHAR(255) DEFAULT NULL, reviews LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', positive_review_pc INT DEFAULT NULL, warranty LONGTEXT DEFAULT NULL, pricing_information LONGTEXT DEFAULT NULL, UNIQUE INDEX business_unique_idx (name, address), PRIMARY KEY(uid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE businesses');
    }
}

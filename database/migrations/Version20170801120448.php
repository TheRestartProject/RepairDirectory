<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170801120448 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE businesses_uid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE businesses (uid INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postcode VARCHAR(255) NOT NULL, geolocation TEXT NOT NULL, description TEXT NOT NULL, landline VARCHAR(255) NOT NULL, mobile VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, local_area VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, products_repaired TEXT NOT NULL, authorised BOOLEAN NOT NULL, qualifications VARCHAR(255) NOT NULL, reviews TEXT NOT NULL, positive_review_pc INT NOT NULL, warranty TEXT NOT NULL, pricing_information TEXT NOT NULL, PRIMARY KEY(uid))');
        $this->addSql('COMMENT ON COLUMN businesses.geolocation IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN businesses.products_repaired IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN businesses.reviews IS \'(DC2Type:array)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE businesses_uid_seq CASCADE');
        $this->addSql('DROP TABLE businesses');
    }
}

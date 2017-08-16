<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170816105856 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE businesses ADD review_source VARCHAR(255) DEFAULT NULL, ADD average_score TINYINT(1) DEFAULT NULL, ADD number_of_reviews INT DEFAULT NULL, ADD warranty_offered TINYINT(1) DEFAULT NULL, DROP reviews');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE businesses ADD reviews LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', DROP review_source, DROP average_score, DROP number_of_reviews, DROP warranty_offered');
    }
}

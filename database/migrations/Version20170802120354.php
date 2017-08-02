<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170802120354 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE businesses (uid INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postcode VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2DCA55EC6339A411 (postcode), PRIMARY KEY(uid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE businesses');
    }
}

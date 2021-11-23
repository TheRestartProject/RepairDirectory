<?php

namespace Database\Migrations\Fixometer;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20181114113811 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // NGM: These migrations are now present in 20170823211259 and not needed here.

        // $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // $this->addSql('ALTER TABLE users MODIFY idusers INT NOT NULL');
        // $this->addSql('ALTER TABLE users DROP PRIMARY KEY');
        // $this->addSql('ALTER TABLE users ADD updated_at DATETIME DEFAULT NULL, DROP modified_at, CHANGE role role INT NOT NULL, CHANGE idusers id INT NOT NULL');
        // $this->addSql('ALTER TABLE users ADD PRIMARY KEY (id)');
        // $this->addSql('ALTER TABLE users MODIFY id INT AUTO_INCREMENT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // $this->addSql('ALTER TABLE users MODIFY id INT NOT NULL');
        // $this->addSql('ALTER TABLE users DROP PRIMARY KEY');
        // $this->addSql('ALTER TABLE users ADD modified_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP updated_at, CHANGE role role INT DEFAULT 3 NOT NULL, CHANGE id idusers INT NOT NULL');
        // $this->addSql('ALTER TABLE users ADD PRIMARY KEY (idusers)');
        // $this->addSql('ALTER TABLE users MODIFY idusers INT AUTO_INCREMENT NOT NULL');
    }
}

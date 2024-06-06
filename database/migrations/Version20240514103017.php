<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240514103017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds field to keep track of businesses opting out of review emails.';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE businesses ADD business_check_mail_optout BOOLEAN DEFAULT 0 NOT NULL AFTER business_check_mail_sent_at');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE businesses DROP business_check_mail_optout');
    }
}

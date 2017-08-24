<?php

namespace Database\Migrations\Fixometer;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170823211259 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(
            'create table sessions
            (
              idsessions int auto_increment
                primary key,
              session varchar(255) not null,
              user int not null,
              created_at timestamp null,
              modified_at timestamp default CURRENT_TIMESTAMP not null,
              constraint session_UNIQUE
              unique (session)
            );'
        );

        $this->addSql(
            'create index idxSessionsUsers
            on sessions (user);'
        );

        $this->addSql(
            'CREATE TABLE users
            (
              idusers INT AUTO_INCREMENT
                PRIMARY KEY,
              email VARCHAR(255) NOT NULL,
              password VARCHAR(60) NOT NULL,
              name VARCHAR(255) NOT NULL,
              role INT DEFAULT 3 not null,
              recovery varchar(45) null,
              recovery_expires timestamp null,
              created_at timestamp null,
              modified_at timestamp default CURRENT_TIMESTAMP not null,
              constraint email_UNIQUE
              unique (email)
            );'
        );
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE sessions');
    }
}

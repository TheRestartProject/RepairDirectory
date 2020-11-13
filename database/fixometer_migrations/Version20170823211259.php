<?php

namespace Database\Migrations\Fixometer;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20170823211259 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // NGM: this migration is no longer relevant as we assume we are
        // working with an existing Restarters install.

        // $builder = new Builder($schema);
        // $this->abortIf($builder->hasTable('users'));

        // $this->addSql(
        //     'CREATE TABLE users
        //     (
        //       id INT AUTO_INCREMENT
        //         PRIMARY KEY,
        //       email VARCHAR(255) NOT NULL,
        //       password VARCHAR(60) NOT NULL,
        //       name VARCHAR(255) NOT NULL,
        //       role INT not null,
        //       recovery varchar(45) null,
        //       recovery_expires timestamp null,
        //       created_at timestamp null,
        //       updated_at datetime default CURRENT_TIMESTAMP not null,
        //       constraint email_UNIQUE
        //       unique (email)
        //     );'
        // );
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // NGM: removing this for now, as I'm wary of a Repair Directory rollback
        // trashing the users table when the connection is pointing at a shared database.
        // $this->addSql('DROP TABLE users');
    }
}

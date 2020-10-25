<?php

namespace Database\Migrations\Fixometer;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20201025171556 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        (new Builder($schema))->table('users', function (Table $table) {
            $table->smallInteger('repairdir_role', false, true)
;
        });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        (new Builder($schema))->table('users', function (Table $table) {
            $table->dropColumn('repairdir_role');
        });
    }
}

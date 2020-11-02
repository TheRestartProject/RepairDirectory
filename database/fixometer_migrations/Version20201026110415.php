<?php

namespace Database\Migrations\Fixometer;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20201026110415 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("insert into repairdir_roles values(1, 'SuperAdmin', now(), now())");
        $this->addSql("insert into repairdir_roles values(2, 'RegionalAdmin', now(), now())");
        $this->addSql("insert into repairdir_roles values(3, 'Editor', now(), now())");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("delete from repairdir_roles where name in ('SuperAdmin', 'RegionalAdmin', 'Editor')");
    }
}

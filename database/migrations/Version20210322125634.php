<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20210322125634 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE regions (uid INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, polygon geometry NOT NULL, PRIMARY KEY(uid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_regions (idusers_regions INT AUTO_INCREMENT NOT NULL, user INT(11) NOT NULL, region INT(11) NOT NULL, PRIMARY KEY(idusers_regions), UNIQUE INDEX users_region_unique_idx(user, region)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        // For our current purposes we don't need complete polygons; bounding rectangles will do.  The code would handle
        // more complete polygons in future, though.
        $this->addSql("INSERT INTO regions (name, polygon) VALUES ('London', GeomFromText('POLYGON((-0.78 51.2, -0.78 51.8, 0.6 51.8,0.6 51.2,-0.78 51.2))'))");
        $this->addSql("INSERT INTO regions (name, polygon) VALUES ('Wales', GeomFromText('POLYGON((-5.371793182658548 51.32990102458417,-2.6032384951585485 51.32990102458417,-2.6032384951585485 53.46775372527346, -5.371793182658548 53.46775372527346, -5.371793182658548 51.32990102458417))'))");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users_regions');
        $this->addSql('DROP TABLE regions');
    }
}

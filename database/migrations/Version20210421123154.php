<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20210421123154 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSQL("CREATE TABLE `submissions` ( `external_id` VARCHAR(32) NOT NULL, `business_name` VARCHAR(255) NOT NULL , `business_website` VARCHAR(255) NULL , `business_borough` VARCHAR(255) NULL , `review_source` VARCHAR(1000) NULL , `extra_info` TEXT NULL , `created_at` TIMESTAMP NOT NULL , `submitted_by_employee` BOOLEAN NOT NULL , `status` ENUM('Added to Directory','Duplicate','Outside Area','Spam','Not considered - other') NULL , UNIQUE (`external_id`)) ENGINE = InnoDB;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSQL("DROP TABLE submissions");
    }
}

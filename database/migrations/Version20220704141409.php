<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20220704141409 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSQL("ALTER TABLE businesses ADD categories_old LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci;");
        $this->addSQL("ALTER TABLE businesses ADD products_repaired_old LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci;");
        $this->addSQL("ALTER TABLE businesses ADD authorised_brands_old LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci;");
        $this->addSQL("UPDATE businesses SET categories_old = categories, products_repaired_old = products_repaired, authorised_brands_old = authorised_brands;");
        $businesses = $this->connection->fetchAllAssociative("SELECT * FROM businesses");

        foreach ($businesses as $business) {
            $this->addSQL("UPDATE businesses SET categories = :cat, products_repaired = :prod, authorised_brands = :brands WHERE uid = :uid", [
                'cat' => json_encode(unserialize($business['categories'])),
                'prod' => json_encode(unserialize($business['products_repaired'])),
                'brands' => json_encode(unserialize($business['authorised_brands'])),
                'uid' => $business['uid']
            ]);
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSQL("UPDATE businesses SET categories = categories_old, products_repaired = products_repaired_old, authorised_brands = authorised_brands_old;");
        $this->addSQL("ALTER TABLE businesses DROP categories_old;");
        $this->addSQL("ALTER TABLE businesses DROP products_repaired_old;");
        $this->addSQL("ALTER TABLE businesses DROP authorised_brands_old;");
    }
}

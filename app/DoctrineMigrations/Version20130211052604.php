<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130211052604 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice_line ADD COLUMN unit_price decimal(16, 4) NOT NULL DEFAULT 0.0");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice_line DROP COLUMN unit_price");
    }
}

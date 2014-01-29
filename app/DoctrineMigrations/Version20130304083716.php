<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130304083716 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_sales_order_line DROP COLUMN is_manually_closed");
        $this->addSql("ALTER TABLE api_quickbooks_sales_order_line DROP COLUMN item_name");
        $this->addSql("ALTER TABLE api_quickbooks_sales_order_line DROP COLUMN cost");
        $this->addSql("ALTER TABLE api_quickbooks_sales_order_line ADD COLUMN cost numeric(16, 4) NOT NULL DEFAULT 0.0");
        $this->addSql("ALTER TABLE api_quickbooks_sales_order_line ADD COLUMN item_name character varying(31)");
        $this->addSql("ALTER TABLE api_quickbooks_sales_order_line ADD COLUMN is_manually_closed boolean NOT NULL DEFAULT false");

        $this->addSql("ALTER TABLE api_quickbooks_invoice_line ADD COLUMN cost numeric(16, 4) NOT NULL DEFAULT 0.0");
        $this->addSql("ALTER TABLE api_quickbooks_invoice_line ADD COLUMN item_name character varying(31)");
    }

    public function down(Schema $schema)
    {
    }
}

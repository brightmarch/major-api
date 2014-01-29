<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130304133550 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice_line ALTER COLUMN quantity_ordered TYPE numeric(16, 4)");
        $this->addSql("ALTER TABLE api_quickbooks_invoice_line ALTER COLUMN quantity_ordered SET DEFAULT 0.0");
        $this->addSql("ALTER TABLE api_quickbooks_sales_order_line ALTER COLUMN quantity_ordered TYPE numeric(16, 4)");
        $this->addSql("ALTER TABLE api_quickbooks_sales_order_line ALTER COLUMN quantity_ordered SET DEFAULT 0.0");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice_line ALTER COLUMN quantity_ordered TYPE integer");
        $this->addSql("ALTER TABLE api_quickbooks_invoice_line ALTER COLUMN quantity_ordered SET DEFAULT 0");
        $this->addSql("ALTER TABLE api_quickbooks_sales_order_line ALTER COLUMN quantity_ordered TYPE integer");
        $this->addSql("ALTER TABLE api_quickbooks_sales_order_line ALTER COLUMN quantity_ordered SET DEFAULT 0");
    }
}

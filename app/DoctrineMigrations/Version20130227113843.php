<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130227113843 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_customer_count integer NOT NULL DEFAULT 0");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_item_count integer NOT NULL DEFAULT 0");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_invoice_count integer NOT NULL DEFAULT 0");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_sales_rep_count integer NOT NULL DEFAULT 0");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_sales_order_count integer NOT NULL DEFAULT 0");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_customer_count");
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_item_count");
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_invoice_count");
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_sales_rep_count");
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_sales_order_count");
    }
}

<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130419044423 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_customer_count");
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_item_count");
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_invoice_count");
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_sales_rep_count");
    }

    public function down(Schema $schema)
    {
    }
}

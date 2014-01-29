<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130314133410 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("DROP TABLE api_quickbooks_sales_order_line CASCADE");
        $this->addSql("DROP TABLE api_quickbooks_sales_order CASCADE");
        $this->addSql("DROP TABLE api_quickbooks_invoice_line CASCADE");
        $this->addSql("DROP TABLE api_quickbooks_invoice CASCADE");
    }

    public function down(Schema $schema)
    {
    }
}

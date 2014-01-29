<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130409133630 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_application RENAME quickbooks_order_count TO quickbooks_invoice_count");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_application RENAME quickbooks_invoice_count TO quickbooks_order_count");
    }
}

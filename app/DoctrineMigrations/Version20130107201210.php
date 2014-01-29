<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130107201210 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice_line DROP CONSTRAINT api_quickbooks_invoice_line_quickbooks_item_id_fkey");
        $this->addSql("ALTER TABLE api_quickbooks_invoice_line ALTER quickbooks_item_id SET NOT NULL");
        $this->addSql("ALTER TABLE api_quickbooks_invoice_line ADD CONSTRAINT api_quickbooks_invoice_line_quickbooks_item_id_fkey FOREIGN KEY (quickbooks_item_id) REFERENCES api_quickbooks_item (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {

    }
}

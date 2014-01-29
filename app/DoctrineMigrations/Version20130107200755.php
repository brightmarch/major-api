<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130107200755 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice DROP CONSTRAINT api_quickbooks_invoice_quickbooks_customer_id_fkey");
        $this->addSql("ALTER TABLE api_quickbooks_invoice ALTER quickbooks_customer_id SET NOT NULL");
        $this->addSql("ALTER TABLE api_quickbooks_invoice ADD CONSTRAINT api_quickbooks_invoice_quickbooks_customer_id_fkey FOREIGN KEY (quickbooks_customer_id) REFERENCES api_quickbooks_customer (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {

    }
}

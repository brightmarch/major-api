<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130303082139 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice ADD COLUMN invoice_type character varying(48)");
        $this->addSql("UPDATE api_quickbooks_invoice SET invoice_type = 'invoice'");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice DROP COLUMN invoice_type");
    }
}

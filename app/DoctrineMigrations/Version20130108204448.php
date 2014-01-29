<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130108204448 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice ALTER COLUMN ref_number SET NOT NULL");
        $this->addSql("CREATE UNIQUE INDEX api_quickbooks_invoice_application_id_ref_number_idx ON api_quickbooks_invoice (application_id, ref_number)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice ALTER COLUMN ref_number DROP NOT NULL");
        $this->addSql("DROP INDEX api_quickbooks_invoice_application_id_ref_number_idx");
    }
}

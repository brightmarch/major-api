<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130215053645 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_response ADD COLUMN xml_size integer NOT NULL DEFAULT 0");
        $this->addSql("ALTER TABLE api_quickbooks_response ADD COLUMN record_count integer NOT NULL DEFAULT 0");
        $this->addSql("ALTER TABLE api_quickbooks_response ADD COLUMN process_time float NOT NULL DEFAULT 0.0");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_response DROP COLUMN xml_size");
        $this->addSql("ALTER TABLE api_quickbooks_response DROP COLUMN record_count");
        $this->addSql("ALTER TABLE api_quickbooks_response DROP COLUMN process_time");
    }
}

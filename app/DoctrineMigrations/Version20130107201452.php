<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130107201452 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice ADD COLUMN quickbooks_edit_sequence character varying(48)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice DROP COLUMN quickbooks_edit_sequence");
    }
}

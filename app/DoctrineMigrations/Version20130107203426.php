<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130107203426 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_invoice ALTER ship_date DROP NOT NULL");
        $this->addSql("ALTER TABLE api_quickbooks_invoice ALTER due_date DROP NOT NULL");
    }

    public function down(Schema $schema)
    {

    }
}

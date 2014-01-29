<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130417062054 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_log DROP COLUMN is_error");
        $this->addSql("ALTER TABLE api_quickbooks_log ADD COLUMN subject character varying(48)");
    }

    public function down(Schema $schema)
    {
    }
}

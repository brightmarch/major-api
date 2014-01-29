<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130102204833 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE UNIQUE INDEX web_application_quickbooks_token_idx ON web_application (quickbooks_token) WHERE quickbooks_token IS NOT NULL");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP INDEX web_application_quickbooks_token_idx");
    }
}

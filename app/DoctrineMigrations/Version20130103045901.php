<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130103045901 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("DROP INDEX api_quickbooks_queue_request_token_idx");
        $this->addSql("ALTER TABLE api_quickbooks_queue DROP COLUMN request_token");

        $this->addSql("DROP INDEX api_quickbooks_response_request_token_idx");
        $this->addSql("ALTER TABLE api_quickbooks_response DROP COLUMN request_token");
    }

    public function down(Schema $schema)
    {
    }
}

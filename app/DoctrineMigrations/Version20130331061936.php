<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130331061936 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_queue ADD COLUMN queue_token character varying(48)");
        $this->addSql("CREATE INDEX api_quickbooks_queue_queue_token_idx ON api_quickbooks_queue (queue_token) WHERE queue_token IS NOT NULL");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP INDEX api_quickbooks_queue_queue_token_idx");
        $this->addSql("ALTER TABLE api_quickbooks_queue DROP COLUMN queue_token");
    }
}

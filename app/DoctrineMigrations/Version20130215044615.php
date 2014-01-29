<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130215044615 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_request_log ADD COLUMN memory_usage float NOT NULL DEFAULT 0.0");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_request_log DROP COLUMN memory_usage");
    }
}

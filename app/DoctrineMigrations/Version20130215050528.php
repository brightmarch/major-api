<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130215050528 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("CREATE INDEX api_request_log_route_idx ON api_request_log (route)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP INDEX api_request_log_route_idx");
    }
}

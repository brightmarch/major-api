<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130425123903 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_stripe_event ADD COLUMN stripe_event_type character varying(96) NOT NULL");
        $this->addSql("CREATE INDEX api_quickbooks_stripe_event_stripe_event_type_idx ON api_quickbooks_stripe_event (stripe_event_type)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP INDEX api_quickbooks_stripe_event_stripe_event_type_idx");
        $this->addSql("ALTER TABLE api_quickbooks_stripe_event DROP COLUMN stripe_event_type");
    }
}

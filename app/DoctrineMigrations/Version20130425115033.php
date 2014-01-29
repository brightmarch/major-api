<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130425115033 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE api_quickbooks_stripe_event (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                account_id integer NOT NULL REFERENCES web_account (id) ON DELETE CASCADE,
                stripe_event_id character varying(96) NOT NULL,
                stripe_event_payload text NOT NULL,
                CONSTRAINT api_quickbooks_stripe_event_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_stripe_event_status_idx ON api_quickbooks_stripe_event (status)");
        $this->addSql("CREATE INDEX api_quickbooks_stripe_event_account_id_idx ON api_quickbooks_stripe_event (account_id)");
        $this->addSql("CREATE UNIQUE INDEX api_quickbooks_stripe_event_stripe_event_id_idx ON api_quickbooks_stripe_event (stripe_event_id)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE api_quickbooks_stripe_event");
    }
}

<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130103033624 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_queue ADD COLUMN request_token character varying(48)");
        $this->addSql("ALTER TABLE api_quickbooks_queue ADD COLUMN request_xml text");
        $this->addSql("CREATE INDEX api_quickbooks_queue_request_token_idx ON api_quickbooks_queue (request_token)");

        $this->addSql("
            CREATE TABLE api_quickbooks_response (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                processed timestamp without time zone,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                request_token character varying(48) NOT NULL,
                response_xml text,
                CONSTRAINT api_quickbooks_response_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_response_status_idx ON api_quickbooks_response (status)");
        $this->addSql("CREATE INDEX api_quickbooks_response_application_id_idx ON api_quickbooks_response (application_id)");
        $this->addSql("CREATE INDEX api_quickbooks_response_request_token_idx ON api_quickbooks_response (request_token)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_queue DROP COLUMN request_token");
        $this->addSql("ALTER TABLE api_quickbooks_queue DROP COLUMN request_xml");

        $this->addSql("DROP TABLE api_quickbooks_response CASCADE");
    }
}

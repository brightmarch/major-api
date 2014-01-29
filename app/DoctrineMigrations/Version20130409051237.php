<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130409051237 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE api_quickbooks_request (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                quickbooks_queue_id integer NOT NULL REFERENCES api_quickbooks_queue (id) ON DELETE CASCADE,
                object_id integer,
                request_xml_hash character varying(48) NOT NULL,
                request_xml text,
                CONSTRAINT api_quickbooks_request_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_request_status_idx ON api_quickbooks_request (status)");
        $this->addSql("CREATE INDEX api_quickbooks_request_application_id_idx ON api_quickbooks_request (application_id)");
        $this->addSql("CREATE INDEX api_quickbooks_request_quickbooks_queue_id_idx ON api_quickbooks_request (quickbooks_queue_id)");
        $this->addSql("CREATE INDEX api_quickbooks_request_object_id_idx ON api_quickbooks_request (object_id) WHERE object_id IS NOT NULL");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE api_quickbooks_request CASCADE");
    }
}

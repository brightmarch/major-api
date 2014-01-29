<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130124044806 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE api_request_log (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                request_method character varying(10) NOT NULL,
                response_code integer NOT NULL,
                route character varying(256) NOT NULL,
                start_time float NOT NULL DEFAULT 0.0,
                end_time float NOT NULL DEFAULT 0.0,
                request_time float NOT NULL DEFAULT 0.0,
                CONSTRAINT api_request_log_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_request_log_status_idx ON api_request_log (status)");
        $this->addSql("CREATE INDEX api_request_log_application_id_idx ON api_request_log (application_id)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE api_request_log CASCADE");
    }
}

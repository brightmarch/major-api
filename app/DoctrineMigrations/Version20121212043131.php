<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20121212043131 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE api_quickbooks_log (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                dismissed timestamp without time zone,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                type character varying(128) NOT NULL,
                is_error boolean NOT NULL DEFAULT false,
                message character varying(1024) NOT NULL,
                CONSTRAINT api_quickbooks_log_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_log_status_idx ON api_quickbooks_log (status)");
        $this->addSql("CREATE INDEX api_quickbooks_log_application_id_idx ON api_quickbooks_log (application_id)");
        $this->addSql("CREATE INDEX api_quickbooks_log_type_idx ON api_quickbooks_log (type)");

        $this->addSql("
            CREATE OR REPLACE FUNCTION enforce_api_quickbooks_log_defaults() RETURNS TRIGGER AS $$
            BEGIN
                NEW.type = LOWER(NEW.type);

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql
        ");

       $this->addSql("
            CREATE TRIGGER enforce_api_quickbooks_log_defaults_on_insert_on_update
            BEFORE INSERT OR UPDATE ON api_quickbooks_log 
            FOR EACH ROW EXECUTE PROCEDURE enforce_api_quickbooks_log_defaults()
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP FUNCTION enforce_api_quickbooks_log_defaults() CASCADE");
        $this->addSql("DROP TABLE api_quickbooks_log CASCADE");
    }
}

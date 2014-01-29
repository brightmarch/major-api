<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130114065759 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE api_quickbooks_sales_rep (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                initial character varying(5) NOT NULL,
                is_active boolean DEFAULT true,
                CONSTRAINT api_quickbooks_sales_rep_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_sales_rep_status_idx ON api_quickbooks_sales_rep (status)");
        $this->addSql("CREATE INDEX api_quickbooks_sales_rep_application_id_idx ON api_quickbooks_sales_rep (application_id)");
        $this->addSql("CREATE UNIQUE INDEX api_quickbooks_sales_rep_application_id_initial_idx ON api_quickbooks_sales_rep (application_id, initial)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE api_quickbooks_sales_rep CASCADE");
    }
}

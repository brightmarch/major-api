<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20121226071727 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_product_name character varying(255)");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_major_version character varying(5)");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_minor_version character varying(5)");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_country character varying(2)");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_supported_qbxml_version character varying(10)");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_is_automatic_login boolean NOT NULL DEFAULT false");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_qb_file_mode character varying(10)");

        $this->addSql("
            CREATE TABLE api_quickbooks_queue (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                processed timestamp without time zone,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                command character varying(128) NOT NULL,
                CONSTRAINT api_quickbooks_queue_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_queue_status_idx ON api_quickbooks_queue (status)");
        $this->addSql("CREATE INDEX api_quickbooks_queue_application_id_idx ON api_quickbooks_queue (application_id)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE api_quickbooks_queue CASCADE");
    }
}

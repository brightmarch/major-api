<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130216141437 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE api_quickbooks_qbxml (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                qbxml_hash character varying(48) NOT NULL,
                qbxml text NOT NULL,
                CONSTRAINT api_quickbooks_qbxml_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_qbxml_status_idx ON api_quickbooks_qbxml (status)");
        $this->addSql("CREATE INDEX api_quickbooks_qbxml_application_id_idx ON api_quickbooks_qbxml (application_id)");
        $this->addSql("CREATE INDEX api_quickbooks_qbxml_qbxml_hash_idx ON api_quickbooks_qbxml (qbxml_hash)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE api_quickbooks_qbxml");
    }
}

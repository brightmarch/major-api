<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130317074356 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE api_quickbooks_account (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                name character varying(31) NOT NULL,
                fullname character varying(159),
                is_active boolean NOT NULL DEFAULT false,
                sublevel integer NOT NULL DEFAULT 0,
                type character varying(48),
                special_type character varying(48),
                account_number character varying(7),
                bank_number character varying(25),
                description character varying(200),
                balance numeric(16, 4) NOT NULL DEFAULT 0.0,
                total_balance numeric(16, 4) NOT NULL DEFAULT 0.0,
                cash_flow_classification character varying(48),
                quickbooks_list_id character varying(128),
                quickbooks_edit_sequence character varying(16),
                CONSTRAINT api_quickbooks_account_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_account_status_idx ON api_quickbooks_account (status)");
        $this->addSql("CREATE INDEX api_quickbooks_account_application_id_idx ON api_quickbooks_account (application_id)");
        $this->addSql("CREATE INDEX api_quickbooks_account_name_idx ON api_quickbooks_account (name)");
        $this->addSql("CREATE INDEX api_quickbooks_account_type_idx ON api_quickbooks_account (type)");
        $this->addSql("CREATE INDEX api_quickbooks_account_quickbooks_list_id_idx ON api_quickbooks_account (quickbooks_list_id)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE api_quickbooks_account");
    }
}

<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20121206200947 extends AbstractMigration
{

    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE web_account (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                email character varying(96) NOT NULL,
                salt character varying(48),
                password_hash character varying(128) NOT NULL,
                first_name character varying(96) NOT NULL,
                last_name character varying(96) NOT NULL,
                role character varying(24) NOT NULL,
                CONSTRAINT web_account_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX web_account_status_idx ON web_account (status)");
        $this->addSql("CREATE UNIQUE INDEX web_account_email_idx ON web_account (email)");

        $this->addSql("
            CREATE OR REPLACE FUNCTION enforce_web_account_defaults() RETURNS TRIGGER AS $$
            BEGIN
                NEW.email = LOWER(NEW.email);
                NEW.role = UPPER(NEW.role);

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql
        ");

       $this->addSql("
            CREATE TRIGGER enforce_web_account_defaults_on_insert_on_update
            BEFORE INSERT OR UPDATE ON web_account
            FOR EACH ROW EXECUTE PROCEDURE enforce_web_account_defaults()
        ");

        $this->addSql("
            CREATE TABLE web_application (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                account_id integer NOT NULL REFERENCES web_account (id) ON DELETE CASCADE,
                name character varying(96) NOT NULL,
                username character varying(48) NOT NULL,
                api_key character varying(48) NOT NULL,
                CONSTRAINT web_application_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");
        
        $this->addSql("CREATE INDEX web_application_status_idx ON web_application (status)");
        $this->addSql("CREATE INDEX web_application_account_id_idx ON web_application (account_id)");
        $this->addSql("CREATE UNIQUE INDEX web_username_idx ON web_application (username)");
        $this->addSql("CREATE UNIQUE INDEX web_username_api_key_idx ON web_application (username, api_key)");

        $this->addSql("
            CREATE OR REPLACE FUNCTION enforce_web_application_defaults() RETURNS TRIGGER AS $$
            BEGIN
                NEW.username = LOWER(NEW.username);

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql
        ");

       $this->addSql("
            CREATE TRIGGER enforce_web_application_defaults_on_insert_on_update
            BEFORE INSERT OR UPDATE ON web_application
            FOR EACH ROW EXECUTE PROCEDURE enforce_web_application_defaults()
        ");

        $this->addSql("
            CREATE TABLE api_quickbooks_customer (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                token character varying(48),
                name character varying(41) NOT NULL,
                is_active boolean NOT NULL DEFAULT true,
                company_name character varying(41),
                salutation character varying(15),
                first_name character varying(25),
                middle_name character varying(5),
                last_name character varying(25),
                job_title character varying(41),
                bill_address1 character varying(41),
                bill_address2 character varying(41),
                bill_address3 character varying(41),
                bill_address4 character varying(41),
                bill_address5 character varying(41),
                bill_city character varying(31),
                bill_state character varying(21),
                bill_postal_code character varying(13),
                bill_country character varying(31),
                bill_note character varying(41),
                ship_address1 character varying(41),
                ship_address2 character varying(41),
                ship_address3 character varying(41),
                ship_address4 character varying(41),
                ship_address5 character varying(41),
                ship_city character varying(31),
                ship_state character varying(21),
                ship_postal_code character varying(13),
                ship_country character varying(31),
                ship_note character varying(41),
                phone character varying(21),
                alt_phone character varying(21),
                fax character varying(21),
                email character varying(256),
                email_cc character varying(256),
                notes text,
                quickbooks_list_id character varying(128),
                quickbooks_txn_id character varying(48),
                quickbooks_txn_number character varying(48),
                CONSTRAINT api_quickbooks_customer_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_customer_status_idx ON api_quickbooks_customer (status)");
        $this->addSql("CREATE INDEX api_quickbooks_customer_token_idx ON api_quickbooks_customer (token)");
        $this->addSql("CREATE INDEX api_quickbooks_customer_application_id_idx ON api_quickbooks_customer (application_id)");
        $this->addSql("CREATE INDEX api_quickbooks_customer_quickbooks_list_id_idx ON api_quickbooks_customer (quickbooks_list_id)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE web_application CASCADE");
        $this->addSql("DROP TABLE web_account CASCADE");
        $this->addSql("DROP TABLE api_quickbooks_customer CASCADE");
        $this->addSql("DROP FUNCTION enforce_web_account_defaults()");
        $this->addSql("DROP FUNCTION enforce_web_application_defaults()");
    }

}

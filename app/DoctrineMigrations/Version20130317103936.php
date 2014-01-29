<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130317103936 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE api_quickbooks_vendor (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                token character varying(48),
                name character varying(31) NOT NULL,
                fullname character varying(159),
                is_active boolean NOT NULL DEFAULT false,
                company_name character varying(41),
                salutation character varying(15),
                first_name character varying(25),
                middle_name character varying(5),
                last_name character varying(25),
                job_title character varying(41),
                vendor_address_address1 character varying(41),
                vendor_address_address2 character varying(41),
                vendor_address_address3 character varying(41),
                vendor_address_address4 character varying(41),
                vendor_address_address5 character varying(41),
                vendor_address_city character varying(31),
                vendor_address_state character varying(21),
                vendor_address_postal_code character varying(13),
                vendor_address_country character varying(31),
                vendor_address_note character varying(41),
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
                contact character varying(41),
                alt_contact character varying(41),
                name_on_check character varying(41),
                account_number character varying(99),
                notes character varying(4095),
                credit_limit numeric(16, 4),
                vendor_tax_identity character varying(15),
                is_vendor_eligible_for_1099 boolean NOT NULL DEFAULT false,
                balance numeric(16, 4),
                quickbooks_list_id character varying(128),
                quickbooks_edit_sequence character varying(16),
                quickbooks_name_token character varying(48) NOT NULL,
                CONSTRAINT api_quickbooks_vendor_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_vendor_status_idx ON api_quickbooks_vendor (status)");
        $this->addSql("CREATE INDEX api_quickbooks_vendor_application_id_idx ON api_quickbooks_vendor (application_id)");
        $this->addSql("CREATE UNIQUE INDEX api_quickbooks_vendor_application_id_quickbooks_name_token_idx ON api_quickbooks_vendor (application_id, quickbooks_name_token)");
        $this->addSql("CREATE INDEX api_quickbooks_vendor_token_idx ON api_quickbooks_vendor (token)");
        $this->addSql("CREATE INDEX api_quickbooks_vendor_quickbooks_list_id_idx ON api_quickbooks_vendor (quickbooks_list_id)");
        $this->addSql("CREATE INDEX api_quickbooks_vendor_quickbooks_name_token_idx ON api_quickbooks_vendor (quickbooks_name_token)");

        $this->addSql("
            CREATE TABLE api_quickbooks_vendor_contact (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                quickbooks_vendor_id integer NOT NULL REFERENCES api_quickbooks_vendor (id) ON DELETE CASCADE,
                salutation character varying(41),
                first_name character varying(25),
                middle_name character varying(5),
                last_name character varying(25),
                job_title character varying(41),
                contact_ref_name1 character varying(40),
                contact_ref_value1 character varying(255),
                contact_ref_name2 character varying(40),
                contact_ref_value2 character varying(255),
                contact_ref_name3 character varying(40),
                contact_ref_value3 character varying(255),
                contact_ref_name4 character varying(40),
                contact_ref_value4 character varying(255),
                contact_ref_name5 character varying(40),
                contact_ref_value5 character varying(255),
                quickbooks_list_id character varying(128),
                quickbooks_edit_sequence character varying(16),
                CONSTRAINT api_quickbooks_vendor_contact_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_vendor_contact_status_idx ON api_quickbooks_vendor_contact (status)");
        $this->addSql("CREATE INDEX api_quickbooks_vendor_contact_quickbooks_vendor_id_idx ON api_quickbooks_vendor_contact (quickbooks_vendor_id)");
        $this->addSql("CREATE INDEX api_quickbooks_vendor_contact_quickbooks_list_id_idx ON api_quickbooks_vendor_contact (quickbooks_list_id)");

        $this->addSql("
            CREATE TABLE api_quickbooks_vendor_note (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                quickbooks_vendor_id integer NOT NULL REFERENCES api_quickbooks_vendor (id) ON DELETE CASCADE,
                note_date timestamp without time zone,
                note character varying(4095),
                quickbooks_list_id character varying(128),
                CONSTRAINT api_quickbooks_vendor_note_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_vendor_note_status_idx ON api_quickbooks_vendor_note (status)");
        $this->addSql("CREATE INDEX api_quickbooks_vendor_note_quickbooks_vendor_id_idx ON api_quickbooks_vendor_note (quickbooks_vendor_id)");
        $this->addSql("CREATE INDEX api_quickbooks_vendor_note_quickbooks_list_id_idx ON api_quickbooks_vendor_note (quickbooks_list_id)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE api_quickbooks_vendor_note CASCADE");
        $this->addSql("DROP TABLE api_quickbooks_vendor_contact CASCADE");
        $this->addSql("DROP TABLE api_quickbooks_vendor CASCADE");
    }
}

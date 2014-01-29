<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20121209064134 extends AbstractMigration
{

    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE api_quickbooks_item (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                type character varying(128) NOT NULL,
                name character varying(31) NOT NULL,
                fullname character varying(159),
                is_active boolean NOT NULL DEFAULT false,
                sublevel integer NOT NULL DEFAULT 0,
                sales_description character varying(4095),
                sales_price numeric(16, 4) NOT NULL DEFAULT 0.0,
                sales_expense numeric(16, 4) NOT NULL DEFAULT 0.0,
                sales_date timestamp without time zone,
                purchase_description character varying(4095),
                purchase_price numeric(16, 4) NOT NULL DEFAULT 0.0,
                purchase_cost numeric(16, 4) NOT NULL DEFAULT 0.0,
                purchase_date timestamp without time zone,
                description character varying(4095),
                item_description character varying(4095),
                price numeric(16, 4) NOT NULL DEFAULT 0.0,
                price_percent numeric(8, 4) NOT NULL DEFAULT 0.0,
                discount_rate numeric(16, 4) NOT NULL DEFAULT 0.0,
                discount_rate_percent numeric(8, 4) NOT NULL DEFAULT 0.0,
                bar_code character varying(50),
                manufacturer_part_number character varying(31),
                quantity_reorder integer NOT NULL DEFAULT 0,
                quantity_on_hand integer NOT NULL DEFAULT 0,
                quantity_on_order integer NOT NULL DEFAULT 0,
                quantity_on_sales_order integer NOT NULL DEFAULT 0,
                average_cost numeric(16, 4) NOT NULL DEFAULT 0.0,
                vendor_or_payee_name character varying(50),
                acquired_as character varying(50),
                asset_description character varying(50),
                location character varying(50),
                po_number character varying(30),
                serial_number character varying(30),
                warranty_expiration_date timestamp without time zone,
                notes character varying(1024),
                asset_number character varying(10),
                cost_basis numeric(16, 4) NOT NULL DEFAULT 0.0,
                year_end_accumulated_depreciation numeric(16, 4) NOT NULL DEFAULT 0.0,
                year_end_book_value numeric(16, 4) NOT NULL DEFAULT 0.0,
                external_guid character varying(48),
                quickbooks_list_id character varying(128),
                quickbooks_edit_sequence character varying(16),
                CONSTRAINT api_quickbooks_item_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_item_status_idx ON api_quickbooks_item (status)");
        $this->addSql("CREATE UNIQUE INDEX api_quickbooks_item_application_id_name_idx ON api_quickbooks_item (application_id, name)");
        $this->addSql("CREATE INDEX api_quickbooks_item_application_id_idx ON api_quickbooks_item (application_id)");
        $this->addSql("CREATE INDEX api_quickbooks_item_name_idx ON api_quickbooks_item (name)");
        $this->addSql("CREATE INDEX api_quickbooks_item_type_idx ON api_quickbooks_item (type)");
        $this->addSql("CREATE INDEX api_quickbooks_item_quickbooks_list_id_idx ON api_quickbooks_item (quickbooks_list_id)");

        $this->addSql("
            CREATE OR REPLACE FUNCTION enforce_api_quickbooks_item_defaults() RETURNS TRIGGER AS $$
            BEGIN
                NEW.type = LOWER(NEW.type);

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql
        ");

       $this->addSql("
            CREATE TRIGGER enforce_api_quickbooks_item_defaults_on_insert_on_update
            BEFORE INSERT OR UPDATE ON api_quickbooks_item 
            FOR EACH ROW EXECUTE PROCEDURE enforce_api_quickbooks_item_defaults()
        ");

        $this->addSql("
            CREATE TABLE api_quickbooks_invoice (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                quickbooks_customer_id integer REFERENCES api_quickbooks_customer (id) ON DELETE SET NULL,
                token character varying(48),
                invoice_date timestamp without time zone NOT NULL,
                due_date timestamp without time zone NOT NULL,
                ship_date timestamp without time zone NOT NULL,
                ref_number character varying(11),
                po_number character varying(25),
                is_pending boolean NOT NULL default false,
                is_finance_charge boolean NOT NULL default false,
                is_to_be_printed boolean NOT NULL default false,
                is_to_be_emailed boolean NOT NULL default false,
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
                fob character varying(13),
                memo character varying(4095),
                quickbooks_list_id character varying(128),
                quickbooks_txn_id character varying(48),
                quickbooks_txn_number character varying(48),
                CONSTRAINT api_quickbooks_invoice_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_invoice_status_idx ON api_quickbooks_invoice (status)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_token_idx ON api_quickbooks_invoice (token)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_application_id_idx ON api_quickbooks_invoice (application_id)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_ref_number_idx ON api_quickbooks_invoice (ref_number) WHERE ref_number IS NOT NULL");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_po_number_idx ON api_quickbooks_invoice (po_number) WHERE po_number IS NOT NULL");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_quickbooks_list_id_idx ON api_quickbooks_invoice (quickbooks_list_id)");

        $this->addSql("
            CREATE TABLE api_quickbooks_invoice_line (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                quickbooks_invoice_id integer NOT NULL REFERENCES api_quickbooks_invoice (id) ON DELETE CASCADE,
                quickbooks_item_id integer REFERENCES api_quickbooks_item (id) ON DELETE SET NULL,
                description character varying(4095),
                quantity_ordered integer NOT NULL DEFAULT 0,
                unit_of_measure character varying(31),
                rate numeric(16, 4) NOT NULL DEFAULT 0.0,
                rate_percent numeric(8, 4) NOT NULL DEFAULT 0.0,
                amount numeric(16, 4) NOT NULL DEFAULT 0.0,
                serial_number character varying(1024),
                lot_number character varying(40),
                other1 character varying(29),
                other2 character varying(29),
                CONSTRAINT api_quickbooks_invoice_line_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_invoice_line_status_idx ON api_quickbooks_invoice_line (status)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_line_quickbooks_invoice_id_idx ON api_quickbooks_invoice_line (quickbooks_invoice_id)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_line_quickbooks_item_id_idx ON api_quickbooks_invoice_line (quickbooks_item_id) WHERE quickbooks_item_id IS NOT NULL");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE api_quickbooks_invoice_line");
        $this->addSql("DROP TABLE api_quickbooks_invoice");
        $this->addSql("DROP TABLE api_quickbooks_item CASCADE");
        $this->addSql("DROP FUNCTION enforce_api_quickbooks_item_defaults() CASCADE");
    }

}

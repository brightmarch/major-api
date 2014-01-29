<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130405101604 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE api_quickbooks_invoice (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                quickbooks_customer_id integer NOT NULL REFERENCES api_quickbooks_customer (id) ON DELETE CASCADE,
                token character varying(48),
                invoice_date timestamp without time zone NOT NULL,
                due_date timestamp without time zone,
                ship_date timestamp without time zone,
                ref_number character varying(11) NOT NULL,
                po_number character varying(25),
                is_pending boolean NOT NULL DEFAULT false,
                is_finance_charge boolean NOT NULL DEFAULT false,
                is_to_be_printed boolean NOT NULL DEFAULT false,
                is_to_be_emailed boolean NOT NULL DEFAULT false,
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
                importable boolean NOT NULL DEFAULT false,
                quickbooks_txn_id character varying(48),
                quickbooks_txn_number character varying(48),
                quickbooks_edit_sequence character varying(48),
                CONSTRAINT api_quickbooks_invoice_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_invoice_status_idx ON api_quickbooks_invoice (status)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_application_id_idx ON api_quickbooks_invoice (application_id)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_quickbooks_customer_id_idx ON api_quickbooks_invoice (quickbooks_customer_id)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_token_idx ON api_quickbooks_invoice (token)");
        $this->addSql("CREATE UNIQUE INDEX api_quickbooks_invoice_application_id_ref_number_idx ON api_quickbooks_invoice (application_id, ref_number)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_ref_number_idx ON api_quickbooks_invoice (ref_number)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_quickbooks_txn_id_idx ON api_quickbooks_invoice (quickbooks_txn_id)");

        $this->addSql("
            CREATE TABLE api_quickbooks_invoice_line (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                quickbooks_invoice_id integer NOT NULL REFERENCES api_quickbooks_invoice (id) ON DELETE CASCADE,
                quickbooks_item_id integer REFERENCES api_quickbooks_item (id) ON DELETE SET NULL,
                item_name character varying(31),
                item_description character varying(4095),
                quantity_ordered numeric(16,4) NOT NULL DEFAULT 0.0,
                unit_of_measure character varying(31),
                rate numeric(16,4) NOT NULL DEFAULT 0.0,
                rate_percent numeric(8,4) NOT NULL DEFAULT 0.0,
                amount numeric(16,4) NOT NULL DEFAULT 0.0,
                serial_number character varying(1024),
                lot_number character varying(40),
                other1 character varying(29),
                other2 character varying(29),
                unit_price numeric(16,4) NOT NULL DEFAULT 0.0,
                cost numeric(16,4) NOT NULL DEFAULT 0.0,
                CONSTRAINT api_quickbooks_invoice_line_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_invoice_line_status_idx ON api_quickbooks_invoice_line (status)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_line_quickbooks_invoice_id_idx ON api_quickbooks_invoice_line (quickbooks_invoice_id)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_line_quickbooks_item_id_idx ON api_quickbooks_invoice_line (quickbooks_item_id)");
        $this->addSql("CREATE INDEX api_quickbooks_invoice_line_item_name_idx ON api_quickbooks_invoice_line (item_name)");

        $this->addSql("INSERT INTO api_quickbooks_invoice (id, created, updated, status, application_id, quickbooks_customer_id, token, invoice_date, due_date, ship_date, ref_number, po_number, is_pending, is_finance_charge, is_to_be_printed, is_to_be_emailed, bill_address1, bill_address2, bill_address3, bill_address4, bill_address5, bill_city, bill_state, bill_postal_code, bill_country, bill_note, ship_address1, ship_address2, ship_address3, ship_address4, ship_address5, ship_city, ship_state, ship_postal_code, ship_country, ship_note, fob, memo, importable, quickbooks_txn_id, quickbooks_txn_number, quickbooks_edit_sequence) SELECT id, created, updated, status, application_id, quickbooks_customer_id, token, order_date, due_date, ship_date, ref_number, po_number, is_pending, is_finance_charge, is_to_be_printed, is_to_be_emailed, bill_address1, bill_address2, bill_address3, bill_address4, bill_address5, bill_city, bill_state, bill_postal_code, bill_country, bill_note, ship_address1, ship_address2, ship_address3, ship_address4, ship_address5, ship_city, ship_state, ship_postal_code, ship_country, ship_note, fob, memo, importable, quickbooks_txn_id, quickbooks_txn_number, quickbooks_edit_sequence FROM api_quickbooks_order WHERE type = 'invoice'");

        $this->addSql("INSERT INTO api_quickbooks_invoice_line (id, created, updated, status, quickbooks_invoice_id, quickbooks_item_id, item_name, item_description, quantity_ordered, unit_of_measure, rate, rate_percent, amount, serial_number, lot_number, other1, other2, unit_price, cost) SELECT id, created, updated, status, quickbooks_order_id, quickbooks_item_id, item_name, item_description, quantity_ordered, unit_of_measure, rate, rate_percent, amount, serial_number, lot_number, other1, other2, unit_price, cost FROM api_quickbooks_order_line");

        $this->addSql("SELECT nextval('api_quickbooks_invoice_id_seq')");
        $this->addSql("SELECT nextval('api_quickbooks_invoice_line_id_seq')");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE api_quickbooks_invoice_line CASCADE");
        $this->addSql("DROP TABLE api_quickbooks_invoice CASCADE");
    }
}

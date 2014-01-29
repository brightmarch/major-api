<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130314122257 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE api_quickbooks_order (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                application_id integer NOT NULL REFERENCES web_application (id) ON DELETE CASCADE,
                quickbooks_customer_id integer NOT NULL REFERENCES api_quickbooks_customer (id) ON DELETE CASCADE,
                type character varying(48) NOT NULL,
                token character varying(48),
                order_date timestamp without time zone NOT NULL,
                due_date timestamp without time zone,
                ship_date timestamp without time zone,
                ref_number character varying(11) NOT NULL,
                po_number character varying(25),
                is_pending boolean NOT NULL DEFAULT false,
                is_finance_charge boolean NOT NULL DEFAULT false,
                is_manually_closed boolean NOT NULL DEFAULT false,
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
                exchange_rate numeric(8,8) NOT NULL DEFAULT 0.0,
                importable boolean NOT NULL DEFAULT false,
                quickbooks_txn_id character varying(48),
                quickbooks_txn_number character varying(48),
                quickbooks_edit_sequence character varying(48),
                CONSTRAINT api_quickbooks_order_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_order_status_idx ON api_quickbooks_order (status)");
        $this->addSql("CREATE INDEX api_quickbooks_order_token_idx ON api_quickbooks_order (token)");
        $this->addSql("CREATE INDEX api_quickbooks_order_type_idx ON api_quickbooks_order (type)");
        $this->addSql("CREATE INDEX api_quickbooks_order_quickbooks_customer_id_idx ON api_quickbooks_order (quickbooks_customer_id)");
        $this->addSql("CREATE INDEX api_quickbooks_order_application_id_idx ON api_quickbooks_order (application_id)");
        $this->addSql("CREATE INDEX api_quickbooks_order_ref_number_idx ON api_quickbooks_order (ref_number)");
        $this->addSql("CREATE UNIQUE INDEX api_quickbooks_order_application_id_ref_number_idx ON api_quickbooks_order (application_id, ref_number)");
        $this->addSql("CREATE INDEX api_quickbooks_order_quickbooks_txn_id_idx ON api_quickbooks_order (quickbooks_txn_id)");

        $this->addSql("
            CREATE TABLE api_quickbooks_order_line (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                quickbooks_order_id integer NOT NULL REFERENCES api_quickbooks_order (id) ON DELETE CASCADE,
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
                is_manually_closed boolean NOT NULL DEFAULT false,
                CONSTRAINT api_quickbooks_order_line_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX api_quickbooks_order_line_status_idx ON api_quickbooks_order_line (status)");
        $this->addSql("CREATE INDEX api_quickbooks_order_line_quickbooks_order_id_idx ON api_quickbooks_order_line (quickbooks_order_id)");
        $this->addSql("CREATE INDEX api_quickbooks_order_line_quickbooks_item_id_idx ON api_quickbooks_order_line (quickbooks_item_id)");
        $this->addSql("CREATE INDEX api_quickbooks_order_line_item_name_idx ON api_quickbooks_order_line (item_name)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE api_quickbooks_order_line CASCADE");
        $this->addSql("DROP TABLE api_quickbooks_order CASCADE");
    }
}

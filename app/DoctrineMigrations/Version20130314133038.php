<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130314133038 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("INSERT INTO api_quickbooks_order (id, created, updated, status, application_id, quickbooks_customer_id, type, token, order_date, due_date, ship_date, ref_number, po_number, is_pending, is_finance_charge, is_manually_closed, is_to_be_printed, is_to_be_emailed, bill_address1, bill_address2, bill_address3, bill_address4, bill_address5, bill_city, bill_state, bill_postal_code, bill_country, bill_note, ship_address1, ship_address2, ship_address3, ship_address4, ship_address5, ship_city, ship_state, ship_postal_code, ship_country, ship_note, fob, memo, exchange_rate, importable, quickbooks_txn_id, quickbooks_txn_number, quickbooks_edit_sequence) SELECT id, created, updated, status, application_id, quickbooks_customer_id, 'invoice', token, invoice_date, due_date, ship_date, ref_number, po_number, is_pending, is_finance_charge, false, is_to_be_printed, is_to_be_emailed, bill_address1, bill_address2, bill_address3, bill_address4, bill_address5, bill_city, bill_state, bill_postal_code, bill_country, bill_note, ship_address1, ship_address2, ship_address3, ship_address4, ship_address5, ship_city, ship_state, ship_postal_code, ship_country, ship_note, fob, memo, exchange_rate, importable, quickbooks_txn_id, quickbooks_txn_number, quickbooks_edit_sequence FROM api_quickbooks_invoice");

        $this->addSql("INSERT INTO api_quickbooks_order_line (id, created, updated, status, quickbooks_order_id, quickbooks_item_id, item_name, item_description, quantity_ordered, unit_of_measure, rate, rate_percent, amount, serial_number, lot_number, other1, other2, unit_price, cost, is_manually_closed) SELECT id, created, updated, status, quickbooks_invoice_id, quickbooks_item_id, item_name, description, quantity_ordered, unit_of_measure, rate, rate_percent, amount, serial_number, lot_number, other1, other2, unit_price, cost, false FROM api_quickbooks_invoice_line");

        $this->addSql("SELECT nextval('api_quickbooks_order_id_seq')");
        $this->addSql("SELECT nextval('api_quickbooks_order_line_id_seq')");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DELETE FROM api_quickbooks_order");
    }
}

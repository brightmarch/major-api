<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130114201155 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_sales_rep ADD COLUMN quickbooks_list_id character varying(128)");
        $this->addSql("ALTER TABLE api_quickbooks_sales_rep ADD COLUMN quickbooks_edit_sequence character varying(48)");

        $this->addSql("CREATE INDEX api_quickbooks_sales_rep_quickbooks_list_id_idx ON api_quickbooks_sales_rep (quickbooks_list_id)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_sales_rep DROP COLUMN quickbooks_list_id");
        $this->addSql("ALTER TABLE api_quickbooks_sales_rep DROP COLUMN quickbooks_edit_sequence");

        $this->addSql("DROP INDEX api_quickbooks_sales_rep_quickbooks_list_id_idx");
    }
}

<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130105064654 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_customer ADD COLUMN quickbooks_name_token character varying(48) NOT NULL");

        $this->addSql("CREATE INDEX api_quickbooks_customer_quickbooks_name_token_idx ON api_quickbooks_customer (quickbooks_name_token)");
        $this->addSql("CREATE UNIQUE INDEX api_quickbooks_customer_application_id_quickbooks_name_token_idx ON api_quickbooks_customer (application_id, quickbooks_name_token)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_customer DROP COLUMN quickbooks_name_token");

        $this->addSql("DROP INDEX api_quickbooks_customer_quickbooks_name_token_idx");
        $this->addSql("DROP INDEX api_quickbooks_customer_application_id_quickbooks_name_token_idx");
    }
}

<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130323052118 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE api_quickbooks_account ADD COLUMN quickbooks_name_token character varying(48)");
        $this->addSql("UPDATE api_quickbooks_account SET quickbooks_name_token = MD5(UPPER(name))");
        $this->addSql("ALTER TABLE api_quickbooks_account ALTER COLUMN quickbooks_name_token SET NOT NULL");
        $this->addSql("CREATE UNIQUE INDEX api_quickbooks_account_application_id_quickbooks_name_token_idx ON api_quickbooks_account (application_id, quickbooks_name_token)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP INDEX api_quickbooks_account_application_id_quickbooks_name_token_idx");
        $this->addSql("ALTER TABLE api_quickbooks_account DROP COLUMN quickbooks_name_token");
    }
}

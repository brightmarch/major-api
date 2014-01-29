<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130102034001 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_owner_id character varying(96)");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_file_id character varying(96)");

        $this->addSql("ALTER TABLE api_quickbooks_queue ADD COLUMN persister character varying(128) NOT NULL");
        $this->addSql("ALTER TABLE api_quickbooks_queue ADD COLUMN token character varying(48) NOT NULL");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_owner_id");
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_file_id");

        $this->addSql("ALTER TABLE api_quickbooks_queue DROP COLUMN persister");
        $this->addSql("ALTER TABLE api_quickbooks_queue DROP COLUMN token");
    }
}

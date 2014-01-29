<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130326042802 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_type character varying(48)");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_realm_id integer");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_oauth_token character varying(256)");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_oauth_token_secret character varying(256)");
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_oauth_token_expiration date");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_type");
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_realm_id");
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_oauth_token");
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_oauth_token_secret");
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_oauth_token_expiration");
    }
}

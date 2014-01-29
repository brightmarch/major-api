<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130425065915 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_account ADD COLUMN stripe_access_token character varying(96)");
        $this->addSql("ALTER TABLE web_account ADD COLUMN stripe_refresh_token character varying(96)");
        $this->addSql("ALTER TABLE web_account ADD COLUMN stripe_publishable_key character varying(96)");
        $this->addSql("ALTER TABLE web_account ADD COLUMN stripe_user_id character varying(96)");

        $this->addSql("CREATE INDEX web_account_stripe_user_id_idx ON web_account (stripe_user_id) WHERE stripe_user_id IS NOT NULL");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_account DROP COLUMN stripe_access_token");
        $this->addSql("ALTER TABLE web_account DROP COLUMN stripe_refresh_token");
        $this->addSql("ALTER TABLE web_account DROP COLUMN stripe_publishable_key");
        $this->addSql("ALTER TABLE web_account DROP COLUMN stripe_user_id");

        $this->addSql("DROP INDEX web_account_stripe_user_id_idx");
    }
}

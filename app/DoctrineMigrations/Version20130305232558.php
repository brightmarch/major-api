<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130305232558 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_account ADD COLUMN billing_digits character varying(4)");
        $this->addSql("ALTER TABLE web_account ADD COLUMN billing_type character varying(20)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_account DROP COLUMN billing_digits");
        $this->addSql("ALTER TABLE web_account DROP COLUMN billing_type");
    }
}

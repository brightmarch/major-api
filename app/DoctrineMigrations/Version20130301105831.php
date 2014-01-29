<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130301105831 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_account ADD COLUMN billing_token character varying(48)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_account DROP COLUMN billing_token");
    }
}

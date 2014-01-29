<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130308133655 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_account ADD COLUMN plan_amount numeric(8, 2) NOT NULL DEFAULT 0.0");
        $this->addSql("ALTER TABLE web_account ADD COLUMN transaction_rate numeric(8, 4) NOT NULL DEFAULT 0.0");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_account DROP COLUMN plan_amount");
        $this->addSql("ALTER TABLE web_account DROP COLUMN transaction_rate");
    }
}

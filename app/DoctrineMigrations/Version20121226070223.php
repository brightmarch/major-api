<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20121226070223 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_application ADD COLUMN quickbooks_token character varying(48)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE web_application DROP COLUMN quickbooks_token"); 
    }
}

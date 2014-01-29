<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130409042642 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("DROP TABLE api_quickbooks_order_line CASCADE");
        $this->addSql("DROP TABLE api_quickbooks_order CASCADE");
    }

    public function down(Schema $schema)
    {
    }
}

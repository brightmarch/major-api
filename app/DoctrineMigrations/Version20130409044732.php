<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130409044732 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("SELECT setval('api_quickbooks_invoice_id_seq', 1000)");
        $this->addSql("SELECT setval('api_quickbooks_invoice_line_id_seq', 1000)");
    }

    public function down(Schema $schema)
    {
    }
}

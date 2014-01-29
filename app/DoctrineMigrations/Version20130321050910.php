<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130321050910 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("INSERT INTO api_quickbooks_queue (created, updated, status, application_id, command, persister) SELECT CURRENT_TIMESTAMP(0), CURRENT_TIMESTAMP(0), 1, id, 'AccountQueryCommand', 'AccountQueryPersister' FROM web_application");
        $this->addSql("INSERT INTO api_quickbooks_queue (created, updated, status, application_id, command, persister) SELECT CURRENT_TIMESTAMP(0), CURRENT_TIMESTAMP(0), 1, id, 'VendorQueryCommand', 'VendorQueryPersister' FROM web_application");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DELETE FROM api_quickbooks_queue WHERE command = 'AccountQueryCommand' AND persister = 'AccountQueryPersister'");
        $this->addSql("DELETE FROM api_quickbooks_queue WHERE command = 'VendorQueryCommand' AND persister = 'VendorQueryPersister'");
    }
}

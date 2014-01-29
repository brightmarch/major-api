<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20121227071612 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE web_session (
                session_id character varying(128) NOT NULL,
                session_value text NOT NULL,
                session_time integer NOT NULL,
                CONSTRAINT web_session_pkey PRIMARY KEY (session_id)
            ) WITH (OIDS=FALSE)
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE web_session");
    }
}

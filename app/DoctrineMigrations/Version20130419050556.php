<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130419050556 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE web_activity (
                id serial NOT NULL,
                created timestamp without time zone NOT NULL,
                updated timestamp without time zone NOT NULL,
                status smallint NOT NULL DEFAULT 0,
                account_id integer NOT NULL REFERENCES web_account (id) ON DELETE CASCADE,
                type character varying(48) NOT NULL,
                subject character varying(48) NOT NULL,
                message character varying(1024) NOT NULL,
                CONSTRAINT web_activity_pkey PRIMARY KEY (id)
            ) WITH (OIDS=FALSE)
        ");

        $this->addSql("CREATE INDEX web_activity_status_idx ON web_activity (status)");
        $this->addSql("CREATE INDEX web_activity_account_id_idx ON web_activity (account_id)");
        $this->addSql("CREATE INDEX web_activity_type_idx ON web_activity (type)");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP TABLE web_activity");
    }
}

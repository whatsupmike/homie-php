<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210906153816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE home_office_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE slack_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE home_office (id INT NOT NULL, slack_user_id INT NOT NULL, since DATE NOT NULL, till DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_845502BFE6AA7332 ON home_office (slack_user_id)');
        $this->addSql('CREATE TABLE slack_user (id INT NOT NULL, user_id VARCHAR(100) NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE home_office ADD CONSTRAINT FK_845502BFE6AA7332 FOREIGN KEY (slack_user_id) REFERENCES slack_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE home_office DROP CONSTRAINT FK_845502BFE6AA7332');
        $this->addSql('DROP SEQUENCE home_office_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE slack_user_id_seq CASCADE');
        $this->addSql('DROP TABLE home_office');
        $this->addSql('DROP TABLE slack_user');
    }
}

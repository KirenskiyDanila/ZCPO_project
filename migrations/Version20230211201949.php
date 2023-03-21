<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230211201949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP CONSTRAINT fk_5a8a6c8da76ed395');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE site_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE site_user (id INT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP INDEX idx_5a8a6c8da76ed395');
        $this->addSql('ALTER TABLE post RENAME COLUMN user_id TO site_user_id');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D5CCA315E FOREIGN KEY (site_user_id) REFERENCES site_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D5CCA315E ON post (site_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D5CCA315E');
        $this->addSql('DROP SEQUENCE site_user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE site_user');
        $this->addSql('DROP INDEX IDX_5A8A6C8D5CCA315E');
        $this->addSql('ALTER TABLE post RENAME COLUMN site_user_id TO user_id');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT fk_5a8a6c8da76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5a8a6c8da76ed395 ON post (user_id)');
    }
}

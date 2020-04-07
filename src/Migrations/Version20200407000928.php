<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407000928 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE adresse DROP CONSTRAINT fk_c35f0816a21bd112');
        $this->addSql('DROP SEQUENCE personne_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE etudiant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP INDEX idx_c35f0816a21bd112');
        $this->addSql('ALTER TABLE adresse RENAME COLUMN personne_id TO etudiant_id');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C35F0816DDEAB1A3 ON adresse (etudiant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE etudiant_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE personne_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE personne (id INT NOT NULL, nom VARCHAR(60) DEFAULT NULL, prenom VARCHAR(60) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE adresse DROP CONSTRAINT FK_C35F0816DDEAB1A3');
        $this->addSql('DROP INDEX IDX_C35F0816DDEAB1A3');
        $this->addSql('ALTER TABLE adresse RENAME COLUMN etudiant_id TO personne_id');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT fk_c35f0816a21bd112 FOREIGN KEY (personne_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c35f0816a21bd112 ON adresse (personne_id)');
    }
}

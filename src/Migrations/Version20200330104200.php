<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330104200 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE absence (id INT NOT NULL, etudiant_id INT NOT NULL, motif VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_765AE0C9DDEAB1A3 ON absence (etudiant_id)');
        $this->addSql('CREATE TABLE personne (id INT NOT NULL, nom VARCHAR(60) DEFAULT NULL, prenom VARCHAR(60) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, nom VARCHAR(60) DEFAULT NULL, prenom VARCHAR(60) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE enseignant ADD password VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE enseignant ALTER email DROP NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD password VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER email DROP NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE adresse DROP CONSTRAINT FK_C35F0816A21BD112');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE admin');
        $this->addSql('ALTER TABLE etudiant DROP password');
        $this->addSql('ALTER TABLE etudiant ALTER email SET NOT NULL');
        $this->addSql('ALTER TABLE enseignant DROP password');
        $this->addSql('ALTER TABLE enseignant ALTER email SET NOT NULL');
    }
}

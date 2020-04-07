<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407145250 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE enseigne_enseignant DROP CONSTRAINT fk_150d15f0e455fcc0');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE enseigne_enseignant');
        $this->addSql('ALTER TABLE admin ADD photo VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE enseignant (id INT NOT NULL, nom VARCHAR(60) DEFAULT NULL, prenom VARCHAR(60) DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_81a72fa1e7927c74 ON enseignant (email)');
        $this->addSql('CREATE TABLE enseigne_enseignant (enseigne_id INT NOT NULL, enseignant_id INT NOT NULL, PRIMARY KEY(enseigne_id, enseignant_id))');
        $this->addSql('CREATE INDEX idx_150d15f06c2a0a71 ON enseigne_enseignant (enseigne_id)');
        $this->addSql('CREATE INDEX idx_150d15f0e455fcc0 ON enseigne_enseignant (enseignant_id)');
        $this->addSql('ALTER TABLE enseigne_enseignant ADD CONSTRAINT fk_150d15f0e455fcc0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE enseigne_enseignant ADD CONSTRAINT fk_150d15f06c2a0a71 FOREIGN KEY (enseigne_id) REFERENCES enseigne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin DROP photo');
    }
}

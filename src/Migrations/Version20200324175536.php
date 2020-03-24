<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200324175536 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE enseigne_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matiere_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE enseigne (id INT NOT NULL, nom VARCHAR(255) NOT NULL, libelle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE enseigne_enseignant (enseigne_id INT NOT NULL, enseignant_id INT NOT NULL, PRIMARY KEY(enseigne_id, enseignant_id))');
        $this->addSql('CREATE INDEX IDX_150D15F06C2A0A71 ON enseigne_enseignant (enseigne_id)');
        $this->addSql('CREATE INDEX IDX_150D15F0E455FCC0 ON enseigne_enseignant (enseignant_id)');
        $this->addSql('CREATE TABLE matiere (id INT NOT NULL, enseigne_id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9014574A6C2A0A71 ON matiere (enseigne_id)');
        $this->addSql('ALTER TABLE enseigne_enseignant ADD CONSTRAINT FK_150D15F06C2A0A71 FOREIGN KEY (enseigne_id) REFERENCES enseigne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE enseigne_enseignant ADD CONSTRAINT FK_150D15F0E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A6C2A0A71 FOREIGN KEY (enseigne_id) REFERENCES enseigne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE enseigne_enseignant DROP CONSTRAINT FK_150D15F06C2A0A71');
        $this->addSql('ALTER TABLE matiere DROP CONSTRAINT FK_9014574A6C2A0A71');
        $this->addSql('DROP SEQUENCE enseigne_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matiere_id_seq CASCADE');
        $this->addSql('DROP TABLE enseigne');
        $this->addSql('DROP TABLE enseigne_enseignant');
        $this->addSql('DROP TABLE matiere');
    }
}

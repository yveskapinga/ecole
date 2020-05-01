<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200501142000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE etudiant (id INT NOT NULL, promotion_id INT DEFAULT NULL, nom VARCHAR(60) DEFAULT NULL, prenom VARCHAR(60) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, adresses VARCHAR(255) DEFAULT NULL, date_de_naissance DATE DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, inscrit BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_717E22E3139DF194 ON etudiant (promotion_id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE absence DROP CONSTRAINT FK_765AE0C9DDEAB1A3');
        $this->addSql('DROP TABLE etudiant');
    }
}

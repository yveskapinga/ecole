<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330121412 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE personne ALTER nom SET NOT NULL');
        $this->addSql('ALTER TABLE personne ALTER prenom SET NOT NULL');
        $this->addSql('ALTER TABLE personne ALTER email SET NOT NULL');
        $this->addSql('ALTER TABLE personne ALTER password SET NOT NULL');
        $this->addSql('ALTER TABLE admin ALTER nom SET NOT NULL');
        $this->addSql('ALTER TABLE admin ALTER prenom SET NOT NULL');
        $this->addSql('ALTER TABLE admin ALTER email SET NOT NULL');
        $this->addSql('ALTER TABLE admin ALTER password SET NOT NULL');
        $this->addSql('ALTER TABLE enseignant ALTER nom SET NOT NULL');
        $this->addSql('ALTER TABLE enseignant ALTER prenom SET NOT NULL');
        $this->addSql('ALTER TABLE enseignant ALTER email SET NOT NULL');
        $this->addSql('ALTER TABLE enseignant ALTER password SET NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER nom SET NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER prenom SET NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER email SET NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER password SET NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE admin ALTER nom DROP NOT NULL');
        $this->addSql('ALTER TABLE admin ALTER prenom DROP NOT NULL');
        $this->addSql('ALTER TABLE admin ALTER email DROP NOT NULL');
        $this->addSql('ALTER TABLE admin ALTER password DROP NOT NULL');
        $this->addSql('ALTER TABLE personne ALTER nom DROP NOT NULL');
        $this->addSql('ALTER TABLE personne ALTER prenom DROP NOT NULL');
        $this->addSql('ALTER TABLE personne ALTER email DROP NOT NULL');
        $this->addSql('ALTER TABLE personne ALTER password DROP NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER nom DROP NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER prenom DROP NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER email DROP NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER password DROP NOT NULL');
        $this->addSql('ALTER TABLE enseignant ALTER nom DROP NOT NULL');
        $this->addSql('ALTER TABLE enseignant ALTER prenom DROP NOT NULL');
        $this->addSql('ALTER TABLE enseignant ALTER email DROP NOT NULL');
        $this->addSql('ALTER TABLE enseignant ALTER password DROP NOT NULL');
    }
}

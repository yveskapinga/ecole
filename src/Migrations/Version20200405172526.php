<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405172526 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE personne ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE personne ALTER password SET NOT NULL');
        $this->addSql('ALTER TABLE admin ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE admin ALTER password SET NOT NULL');
        $this->addSql('ALTER TABLE enseignant ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE enseignant ALTER password SET NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER password SET NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE personne DROP roles');
        $this->addSql('ALTER TABLE personne ALTER password DROP NOT NULL');
        $this->addSql('ALTER TABLE admin DROP roles');
        $this->addSql('ALTER TABLE admin ALTER password DROP NOT NULL');
        $this->addSql('ALTER TABLE etudiant DROP roles');
        $this->addSql('ALTER TABLE etudiant ALTER password DROP NOT NULL');
        $this->addSql('ALTER TABLE enseignant DROP roles');
        $this->addSql('ALTER TABLE enseignant ALTER password DROP NOT NULL');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200406235845 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE enseignant ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE enseignant DROP photo');
        $this->addSql('ALTER TABLE enseignant ALTER email SET NOT NULL');
        $this->addSql('ALTER TABLE enseignant ALTER email TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE enseignant ALTER password SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81A72FA1E7927C74 ON enseignant (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_81A72FA1E7927C74');
        $this->addSql('ALTER TABLE enseignant ADD photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE enseignant DROP roles');
        $this->addSql('ALTER TABLE enseignant ALTER email DROP NOT NULL');
        $this->addSql('ALTER TABLE enseignant ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE enseignant ALTER password DROP NOT NULL');
    }
}

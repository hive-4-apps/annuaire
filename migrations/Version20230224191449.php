<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224191449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre ADD statut_professionnel_id INT DEFAULT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB29A6A09A47 FOREIGN KEY (statut_professionnel_id) REFERENCES statut_pro (id)');
        $this->addSql('CREATE INDEX IDX_F6B4FB29A6A09A47 ON membre (statut_professionnel_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB29A6A09A47');
        $this->addSql('DROP INDEX IDX_F6B4FB29A6A09A47 ON membre');
        $this->addSql('ALTER TABLE membre DROP statut_professionnel_id, DROP nom, DROP prenom');
    }
}

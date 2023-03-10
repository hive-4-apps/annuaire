<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224180916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE statut_pro ADD etat_id INT NOT NULL, DROP status');
        $this->addSql('ALTER TABLE statut_pro ADD CONSTRAINT FK_7FB5A4DD5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_7FB5A4DD5E86FF ON statut_pro (etat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statut_pro DROP FOREIGN KEY FK_7FB5A4DD5E86FF');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP INDEX IDX_7FB5A4DD5E86FF ON statut_pro');
        $this->addSql('ALTER TABLE statut_pro ADD status VARCHAR(255) NOT NULL, DROP etat_id');
    }
}

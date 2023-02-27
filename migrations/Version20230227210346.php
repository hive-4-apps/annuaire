<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227210346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pratique_asso ADD etat_id INT NOT NULL');
        $this->addSql('ALTER TABLE pratique_asso ADD CONSTRAINT FK_D32BC66AD5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_D32BC66AD5E86FF ON pratique_asso (etat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pratique_asso DROP FOREIGN KEY FK_D32BC66AD5E86FF');
        $this->addSql('DROP INDEX IDX_D32BC66AD5E86FF ON pratique_asso');
        $this->addSql('ALTER TABLE pratique_asso DROP etat_id');
    }
}

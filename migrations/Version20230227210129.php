<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227210129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE connaissance ADD etat_id INT NOT NULL');
        $this->addSql('ALTER TABLE connaissance ADD CONSTRAINT FK_3FCAE300D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_3FCAE300D5E86FF ON connaissance (etat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE connaissance DROP FOREIGN KEY FK_3FCAE300D5E86FF');
        $this->addSql('DROP INDEX IDX_3FCAE300D5E86FF ON connaissance');
        $this->addSql('ALTER TABLE connaissance DROP etat_id');
    }
}

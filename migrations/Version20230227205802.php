<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227205802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite_pro ADD etat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activite_pro ADD CONSTRAINT FK_BC9D32FED5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_BC9D32FED5E86FF ON activite_pro (etat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite_pro DROP FOREIGN KEY FK_BC9D32FED5E86FF');
        $this->addSql('DROP INDEX IDX_BC9D32FED5E86FF ON activite_pro');
        $this->addSql('ALTER TABLE activite_pro DROP etat_id');
    }
}

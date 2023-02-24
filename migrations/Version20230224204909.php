<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224204909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE membre_activite_pro (membre_id INT NOT NULL, activite_pro_id INT NOT NULL, INDEX IDX_1532AA8F6A99F74A (membre_id), INDEX IDX_1532AA8FBAD520DE (activite_pro_id), PRIMARY KEY(membre_id, activite_pro_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membre_activite_pro ADD CONSTRAINT FK_1532AA8F6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_activite_pro ADD CONSTRAINT FK_1532AA8FBAD520DE FOREIGN KEY (activite_pro_id) REFERENCES activite_pro (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre_activite_pro DROP FOREIGN KEY FK_1532AA8F6A99F74A');
        $this->addSql('ALTER TABLE membre_activite_pro DROP FOREIGN KEY FK_1532AA8FBAD520DE');
        $this->addSql('DROP TABLE membre_activite_pro');
    }
}

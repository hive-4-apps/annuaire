<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224210942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE membre_centre_interet (membre_id INT NOT NULL, centre_interet_id INT NOT NULL, INDEX IDX_29101E8E6A99F74A (membre_id), INDEX IDX_29101E8E55BBC1E1 (centre_interet_id), PRIMARY KEY(membre_id, centre_interet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membre_centre_interet ADD CONSTRAINT FK_29101E8E6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_centre_interet ADD CONSTRAINT FK_29101E8E55BBC1E1 FOREIGN KEY (centre_interet_id) REFERENCES centre_interet (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre_centre_interet DROP FOREIGN KEY FK_29101E8E6A99F74A');
        $this->addSql('ALTER TABLE membre_centre_interet DROP FOREIGN KEY FK_29101E8E55BBC1E1');
        $this->addSql('DROP TABLE membre_centre_interet');
    }
}

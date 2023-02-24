<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224211313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE connaissance (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE connaissance_connaissance (connaissance_source INT NOT NULL, connaissance_target INT NOT NULL, INDEX IDX_8064FDF03D84E951 (connaissance_source), INDEX IDX_8064FDF02461B9DE (connaissance_target), PRIMARY KEY(connaissance_source, connaissance_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE connaissance_connaissance ADD CONSTRAINT FK_8064FDF03D84E951 FOREIGN KEY (connaissance_source) REFERENCES connaissance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE connaissance_connaissance ADD CONSTRAINT FK_8064FDF02461B9DE FOREIGN KEY (connaissance_target) REFERENCES connaissance (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE connaissance_connaissance DROP FOREIGN KEY FK_8064FDF03D84E951');
        $this->addSql('ALTER TABLE connaissance_connaissance DROP FOREIGN KEY FK_8064FDF02461B9DE');
        $this->addSql('DROP TABLE connaissance');
        $this->addSql('DROP TABLE connaissance_connaissance');
    }
}

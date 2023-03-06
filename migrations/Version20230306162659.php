<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230306162659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre ADD region_id INT DEFAULT NULL, ADD municipio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB2998260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB2958BC1BE0 FOREIGN KEY (municipio_id) REFERENCES municipio (id)');
        $this->addSql('CREATE INDEX IDX_F6B4FB2998260155 ON membre (region_id)');
        $this->addSql('CREATE INDEX IDX_F6B4FB2958BC1BE0 ON membre (municipio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB2998260155');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB2958BC1BE0');
        $this->addSql('DROP INDEX IDX_F6B4FB2998260155 ON membre');
        $this->addSql('DROP INDEX IDX_F6B4FB2958BC1BE0 ON membre');
        $this->addSql('ALTER TABLE membre DROP region_id, DROP municipio_id');
    }
}

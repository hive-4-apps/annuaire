<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224212744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE membre_connaissance (membre_id INT NOT NULL, connaissance_id INT NOT NULL, INDEX IDX_96657B716A99F74A (membre_id), INDEX IDX_96657B7168A34E8E (connaissance_id), PRIMARY KEY(membre_id, connaissance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre_pratique_asso (membre_id INT NOT NULL, pratique_asso_id INT NOT NULL, INDEX IDX_F48028586A99F74A (membre_id), INDEX IDX_F4802858121D029D (pratique_asso_id), PRIMARY KEY(membre_id, pratique_asso_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membre_connaissance ADD CONSTRAINT FK_96657B716A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_connaissance ADD CONSTRAINT FK_96657B7168A34E8E FOREIGN KEY (connaissance_id) REFERENCES connaissance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_pratique_asso ADD CONSTRAINT FK_F48028586A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_pratique_asso ADD CONSTRAINT FK_F4802858121D029D FOREIGN KEY (pratique_asso_id) REFERENCES pratique_asso (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre ADD lien_web VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre_connaissance DROP FOREIGN KEY FK_96657B716A99F74A');
        $this->addSql('ALTER TABLE membre_connaissance DROP FOREIGN KEY FK_96657B7168A34E8E');
        $this->addSql('ALTER TABLE membre_pratique_asso DROP FOREIGN KEY FK_F48028586A99F74A');
        $this->addSql('ALTER TABLE membre_pratique_asso DROP FOREIGN KEY FK_F4802858121D029D');
        $this->addSql('DROP TABLE membre_connaissance');
        $this->addSql('DROP TABLE membre_pratique_asso');
        $this->addSql('ALTER TABLE membre DROP lien_web');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224212146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pratique_asso (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pratique_asso_pratique_asso (pratique_asso_source INT NOT NULL, pratique_asso_target INT NOT NULL, INDEX IDX_608D49DBCC3E7E90 (pratique_asso_source), INDEX IDX_608D49DBD5DB2E1F (pratique_asso_target), PRIMARY KEY(pratique_asso_source, pratique_asso_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pratique_asso_pratique_asso ADD CONSTRAINT FK_608D49DBCC3E7E90 FOREIGN KEY (pratique_asso_source) REFERENCES pratique_asso (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pratique_asso_pratique_asso ADD CONSTRAINT FK_608D49DBD5DB2E1F FOREIGN KEY (pratique_asso_target) REFERENCES pratique_asso (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pratique_asso_pratique_asso DROP FOREIGN KEY FK_608D49DBCC3E7E90');
        $this->addSql('ALTER TABLE pratique_asso_pratique_asso DROP FOREIGN KEY FK_608D49DBD5DB2E1F');
        $this->addSql('DROP TABLE pratique_asso');
        $this->addSql('DROP TABLE pratique_asso_pratique_asso');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224205816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE centre_interet (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centre_interet_centre_interet (centre_interet_source INT NOT NULL, centre_interet_target INT NOT NULL, INDEX IDX_5A8B53296EDB86F1 (centre_interet_source), INDEX IDX_5A8B5329773ED67E (centre_interet_target), PRIMARY KEY(centre_interet_source, centre_interet_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE centre_interet_centre_interet ADD CONSTRAINT FK_5A8B53296EDB86F1 FOREIGN KEY (centre_interet_source) REFERENCES centre_interet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE centre_interet_centre_interet ADD CONSTRAINT FK_5A8B5329773ED67E FOREIGN KEY (centre_interet_target) REFERENCES centre_interet (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centre_interet_centre_interet DROP FOREIGN KEY FK_5A8B53296EDB86F1');
        $this->addSql('ALTER TABLE centre_interet_centre_interet DROP FOREIGN KEY FK_5A8B5329773ED67E');
        $this->addSql('DROP TABLE centre_interet');
        $this->addSql('DROP TABLE centre_interet_centre_interet');
    }
}

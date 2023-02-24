<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224201955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite_pro ADD code_grand_domaine VARCHAR(2) NOT NULL, ADD code_domaine SMALLINT NOT NULL, ADD appelation_domaine VARCHAR(255) NOT NULL, ADD code_ogr INT DEFAULT NULL, ADD appelation_metier VARCHAR(255) NOT NULL, CHANGE label appelation_grand_domaine VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite_pro ADD label VARCHAR(255) NOT NULL, DROP code_grand_domaine, DROP appelation_grand_domaine, DROP code_domaine, DROP appelation_domaine, DROP code_ogr, DROP appelation_metier');
    }
}

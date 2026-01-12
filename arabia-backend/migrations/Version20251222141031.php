<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251222141031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD roles JSON NOT NULL, DROP role, CHANGE email email VARCHAR(180) NOT NULL, CHANGE mot_de_passe password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur RENAME INDEX uniq_1d1c63b3e7927c74 TO UNIQ_IDENTIFIER_EMAIL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD role VARCHAR(20) NOT NULL, DROP roles, CHANGE email email VARCHAR(100) NOT NULL, CHANGE password mot_de_passe VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur RENAME INDEX uniq_identifier_email TO UNIQ_1D1C63B3E7927C74');
    }
}

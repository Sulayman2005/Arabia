<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251222104619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, date_commande DATE NOT NULL, statut VARCHAR(30) NOT NULL, total NUMERIC(10, 2) NOT NULL, INDEX IDX_6EEAA67DFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concerne (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_37FF4F7B82EA2E54 (commande_id), INDEX IDX_37FF4F7BF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favori (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, produit_id INT NOT NULL, date_ajout DATE NOT NULL, INDEX IDX_EF85A2CCFB88E14F (utilisateur_id), INDEX IDX_EF85A2CCF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, moyen_paiement VARCHAR(30) NOT NULL, statut VARCHAR(30) NOT NULL, date_paiement DATE NOT NULL, UNIQUE INDEX UNIQ_B1DC7A1E82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, catgeorie_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, prix NUMERIC(10, 0) NOT NULL, stock INT NOT NULL, image VARCHAR(255) NOT NULL, date_ajout DATE NOT NULL, INDEX IDX_29A5EC27D026C8D6 (catgeorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, role VARCHAR(20) NOT NULL, date_inscription DATE NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE concerne ADD CONSTRAINT FK_37FF4F7B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE concerne ADD CONSTRAINT FK_37FF4F7BF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CCF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27D026C8D6 FOREIGN KEY (catgeorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFB88E14F');
        $this->addSql('ALTER TABLE concerne DROP FOREIGN KEY FK_37FF4F7B82EA2E54');
        $this->addSql('ALTER TABLE concerne DROP FOREIGN KEY FK_37FF4F7BF347EFB');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CCFB88E14F');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CCF347EFB');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E82EA2E54');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27D026C8D6');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE concerne');
        $this->addSql('DROP TABLE favori');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE utilisateur');
    }
}

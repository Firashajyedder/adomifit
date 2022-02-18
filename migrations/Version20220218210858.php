<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220218210858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF3C105691');
        $this->addSql('ALTER TABLE regime DROP FOREIGN KEY FK_AA864A7C279DA68A');
        $this->addSql('CREATE TABLE commande_produit (commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_DF1E9E8782EA2E54 (commande_id), INDEX IDX_DF1E9E87F347EFB (produit_id), PRIMARY KEY(commande_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E8782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E87F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE coach');
        $this->addSql('DROP TABLE nutritionniste');
        $this->addSql('DROP INDEX IDX_6EEAA67D19EB6921 ON commande');
        $this->addSql('ALTER TABLE commande CHANGE client_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DA76ED395 ON commande (user_id)');
        $this->addSql('DROP INDEX IDX_3DDCB9FF3C105691 ON programme');
        $this->addSql('ALTER TABLE programme CHANGE coach_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3DDCB9FFA76ED395 ON programme (user_id)');
        $this->addSql('DROP INDEX IDX_AA864A7C279DA68A ON regime');
        $this->addSql('ALTER TABLE regime CHANGE nutritionniste_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE regime ADD CONSTRAINT FK_AA864A7CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AA864A7CA76ED395 ON regime (user_id)');
        $this->addSql('ALTER TABLE suivi_programme ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE suivi_programme ADD CONSTRAINT FK_547C4291A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_547C4291A76ED395 ON suivi_programme (user_id)');
        $this->addSql('ALTER TABLE suivi_regime ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE suivi_regime ADD CONSTRAINT FK_842372EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_842372EA76ED395 ON suivi_regime (user_id)');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(255) NOT NULL, ADD photo VARCHAR(255) NOT NULL, ADD poid VARCHAR(255) DEFAULT NULL, ADD taille VARCHAR(255) DEFAULT NULL, ADD sexe VARCHAR(255) DEFAULT NULL, ADD atestation VARCHAR(255) DEFAULT NULL, ADD temoignage VARCHAR(255) DEFAULT NULL, ADD niveau VARCHAR(255) DEFAULT NULL, ADD experiance VARCHAR(255) DEFAULT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, poid INT DEFAULT NULL, taille INT DEFAULT NULL, sexe VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE coach (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, atestation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, niveau VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, experiance VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nutritionniste (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, atestation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, temoignage VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE commande_produit');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('DROP INDEX IDX_6EEAA67DA76ED395 ON commande');
        $this->addSql('ALTER TABLE commande CHANGE user_id client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6EEAA67D19EB6921 ON commande (client_id)');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FFA76ED395');
        $this->addSql('DROP INDEX IDX_3DDCB9FFA76ED395 ON programme');
        $this->addSql('ALTER TABLE programme CHANGE user_id coach_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3DDCB9FF3C105691 ON programme (coach_id)');
        $this->addSql('ALTER TABLE regime DROP FOREIGN KEY FK_AA864A7CA76ED395');
        $this->addSql('DROP INDEX IDX_AA864A7CA76ED395 ON regime');
        $this->addSql('ALTER TABLE regime CHANGE user_id nutritionniste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE regime ADD CONSTRAINT FK_AA864A7C279DA68A FOREIGN KEY (nutritionniste_id) REFERENCES nutritionniste (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AA864A7C279DA68A ON regime (nutritionniste_id)');
        $this->addSql('ALTER TABLE suivi_programme DROP FOREIGN KEY FK_547C4291A76ED395');
        $this->addSql('DROP INDEX IDX_547C4291A76ED395 ON suivi_programme');
        $this->addSql('ALTER TABLE suivi_programme DROP user_id');
        $this->addSql('ALTER TABLE suivi_regime DROP FOREIGN KEY FK_842372EA76ED395');
        $this->addSql('DROP INDEX IDX_842372EA76ED395 ON suivi_regime');
        $this->addSql('ALTER TABLE suivi_regime DROP user_id');
        $this->addSql('ALTER TABLE user DROP role, DROP photo, DROP poid, DROP taille, DROP sexe, DROP atestation, DROP temoignage, DROP niveau, DROP experiance, CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL');
    }
}

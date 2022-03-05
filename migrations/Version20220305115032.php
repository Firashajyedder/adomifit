<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220305115032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achat_billet (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, billet_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_DB7A2A33A76ED395 (user_id), INDEX IDX_DB7A2A3344973C78 (billet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achat_billet ADD CONSTRAINT FK_DB7A2A33A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE achat_billet ADD CONSTRAINT FK_DB7A2A3344973C78 FOREIGN KEY (billet_id) REFERENCES billet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE achat_billet');
    }
}

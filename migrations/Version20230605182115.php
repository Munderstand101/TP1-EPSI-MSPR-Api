<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605182115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cardening_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, plant_id INT DEFAULT NULL, INDEX IDX_61E59DEDA76ED395 (user_id), INDEX IDX_61E59DED1D935652 (plant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cardening_request ADD CONSTRAINT FK_61E59DEDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cardening_request ADD CONSTRAINT FK_61E59DED1D935652 FOREIGN KEY (plant_id) REFERENCES plante (id)');
        $this->addSql('ALTER TABLE plante ADD photo VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cardening_request DROP FOREIGN KEY FK_61E59DEDA76ED395');
        $this->addSql('ALTER TABLE cardening_request DROP FOREIGN KEY FK_61E59DED1D935652');
        $this->addSql('DROP TABLE cardening_request');
        $this->addSql('ALTER TABLE plante DROP photo');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230603220703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE botanist DROP FOREIGN KEY FK_7176BA06A76ED395');
        $this->addSql('DROP INDEX UNIQ_7176BA06A76ED395 ON botanist');
        $this->addSql('ALTER TABLE botanist DROP user_id');
        $this->addSql('ALTER TABLE user ADD address VARCHAR(255) NOT NULL, ADD zipcode VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD longitude DOUBLE PRECISION NOT NULL, ADD latitude DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE botanist ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE botanist ADD CONSTRAINT FK_7176BA06A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7176BA06A76ED395 ON botanist (user_id)');
        $this->addSql('ALTER TABLE user DROP address, DROP zipcode, DROP city, DROP longitude, DROP latitude');
    }
}

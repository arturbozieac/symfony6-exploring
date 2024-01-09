<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109082504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book CHANGE isbn isbn VARCHAR(20) NOT NULL, CHANGE plot plot LONGTEXT NOT NULL, CHANGE cover cover VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE comment ADD title VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE movie CHANGE released_at released_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie CHANGE released_at released_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE book CHANGE isbn isbn VARCHAR(50) NOT NULL, CHANGE plot plot LONGTEXT DEFAULT NULL, CHANGE cover cover VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE comment DROP title, DROP email');
    }
}

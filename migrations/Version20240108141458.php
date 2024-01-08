<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108141458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add book entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) DEFAULT NULL, isbn VARCHAR(50) NOT NULL, plot LONGTEXT DEFAULT NULL, released_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', cover VARCHAR(50) NOT NULL, price INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE book');
    }
}

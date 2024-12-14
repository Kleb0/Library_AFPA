<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241214011245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_borrowed_book (book_id INT NOT NULL, borrowed_book_id INT NOT NULL, INDEX IDX_354080B016A2B381 (book_id), INDEX IDX_354080B02913FDE8 (borrowed_book_id), PRIMARY KEY(book_id, borrowed_book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE borrowed_book (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, book_name VARCHAR(255) NOT NULL, borrow_date DATETIME NOT NULL, return_date DATETIME NOT NULL, borrowed_condition VARCHAR(255) NOT NULL, returned_condition VARCHAR(255) DEFAULT NULL, borrower_name VARCHAR(255) NOT NULL, INDEX IDX_50A9B8BC16A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_borrowed_book ADD CONSTRAINT FK_354080B016A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_borrowed_book ADD CONSTRAINT FK_354080B02913FDE8 FOREIGN KEY (borrowed_book_id) REFERENCES borrowed_book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrowed_book ADD CONSTRAINT FK_50A9B8BC16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_borrowed_book DROP FOREIGN KEY FK_354080B016A2B381');
        $this->addSql('ALTER TABLE book_borrowed_book DROP FOREIGN KEY FK_354080B02913FDE8');
        $this->addSql('ALTER TABLE borrowed_book DROP FOREIGN KEY FK_50A9B8BC16A2B381');
        $this->addSql('DROP TABLE book_borrowed_book');
        $this->addSql('DROP TABLE borrowed_book');
    }
}

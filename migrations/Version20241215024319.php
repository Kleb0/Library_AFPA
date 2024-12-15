<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241215024319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_borrowed_book (book_id INT NOT NULL, borrowed_book_id INT NOT NULL, INDEX IDX_354080B016A2B381 (book_id), INDEX IDX_354080B02913FDE8 (borrowed_book_id), PRIMARY KEY(book_id, borrowed_book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_comment (book_id INT NOT NULL, comment_id INT NOT NULL, INDEX IDX_7547AFA16A2B381 (book_id), INDEX IDX_7547AFAF8697D13 (comment_id), PRIMARY KEY(book_id, comment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE borrow_history_book (borrow_history_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_302199C913DE62CA (borrow_history_id), INDEX IDX_302199C916A2B381 (book_id), PRIMARY KEY(borrow_history_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_borrowed_book ADD CONSTRAINT FK_354080B016A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_borrowed_book ADD CONSTRAINT FK_354080B02913FDE8 FOREIGN KEY (borrowed_book_id) REFERENCES borrowed_book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_comment ADD CONSTRAINT FK_7547AFA16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_comment ADD CONSTRAINT FK_7547AFAF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow_history_book ADD CONSTRAINT FK_302199C913DE62CA FOREIGN KEY (borrow_history_id) REFERENCES borrow_history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow_history_book ADD CONSTRAINT FK_302199C916A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow_history DROP FOREIGN KEY FK_794A76CF16A2B381');
        $this->addSql('DROP INDEX IDX_794A76CF16A2B381 ON borrow_history');
        $this->addSql('ALTER TABLE borrow_history DROP book_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_borrowed_book DROP FOREIGN KEY FK_354080B016A2B381');
        $this->addSql('ALTER TABLE book_borrowed_book DROP FOREIGN KEY FK_354080B02913FDE8');
        $this->addSql('ALTER TABLE book_comment DROP FOREIGN KEY FK_7547AFA16A2B381');
        $this->addSql('ALTER TABLE book_comment DROP FOREIGN KEY FK_7547AFAF8697D13');
        $this->addSql('ALTER TABLE borrow_history_book DROP FOREIGN KEY FK_302199C913DE62CA');
        $this->addSql('ALTER TABLE borrow_history_book DROP FOREIGN KEY FK_302199C916A2B381');
        $this->addSql('DROP TABLE book_borrowed_book');
        $this->addSql('DROP TABLE book_comment');
        $this->addSql('DROP TABLE borrow_history_book');
        $this->addSql('ALTER TABLE borrow_history ADD book_id INT NOT NULL');
        $this->addSql('ALTER TABLE borrow_history ADD CONSTRAINT FK_794A76CF16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_794A76CF16A2B381 ON borrow_history (book_id)');
    }
}

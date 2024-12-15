<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241215012054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE borrow_history_book (borrow_history_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_302199C913DE62CA (borrow_history_id), INDEX IDX_302199C916A2B381 (book_id), PRIMARY KEY(borrow_history_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE borrow_history_book ADD CONSTRAINT FK_302199C913DE62CA FOREIGN KEY (borrow_history_id) REFERENCES borrow_history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow_history_book ADD CONSTRAINT FK_302199C916A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow_history_books DROP FOREIGN KEY FK_F986948613DE62CA');
        $this->addSql('ALTER TABLE borrow_history_books DROP FOREIGN KEY FK_F986948616A2B381');
        $this->addSql('DROP TABLE borrow_history_books');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE borrow_history_books (borrow_history_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_F986948616A2B381 (book_id), INDEX IDX_F986948613DE62CA (borrow_history_id), PRIMARY KEY(borrow_history_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE borrow_history_books ADD CONSTRAINT FK_F986948613DE62CA FOREIGN KEY (borrow_history_id) REFERENCES borrow_history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow_history_books ADD CONSTRAINT FK_F986948616A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borrow_history_book DROP FOREIGN KEY FK_302199C913DE62CA');
        $this->addSql('ALTER TABLE borrow_history_book DROP FOREIGN KEY FK_302199C916A2B381');
        $this->addSql('DROP TABLE borrow_history_book');
    }
}

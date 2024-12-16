<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241216000314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reserved_room (user_id INT NOT NULL, work_room_id INT NOT NULL, INDEX IDX_223AE444A76ED395 (user_id), INDEX IDX_223AE44481DCC8B1 (work_room_id), PRIMARY KEY(user_id, work_room_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_rooms (id INT AUTO_INCREMENT NOT NULL, max_capacity INT NOT NULL, equipment JSON NOT NULL COMMENT \'(DC2Type:json)\', reservation_date DATETIME NOT NULL, reservation_time TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reserved_room ADD CONSTRAINT FK_223AE444A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reserved_room ADD CONSTRAINT FK_223AE44481DCC8B1 FOREIGN KEY (work_room_id) REFERENCES work_rooms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserved_room DROP FOREIGN KEY FK_223AE444A76ED395');
        $this->addSql('ALTER TABLE reserved_room DROP FOREIGN KEY FK_223AE44481DCC8B1');
        $this->addSql('DROP TABLE reserved_room');
        $this->addSql('DROP TABLE work_rooms');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395 ON comment');
    }
}

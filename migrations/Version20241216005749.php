<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241216005749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE work_rooms ADD start_reservation_date DATE NOT NULL, ADD end_reservation_date DATE NOT NULL, ADD excluded_days LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', DROP reservation_date, DROP reservation_time');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE work_rooms ADD reservation_date DATETIME NOT NULL, ADD reservation_time TIME NOT NULL, DROP start_reservation_date, DROP end_reservation_date, DROP excluded_days');
    }
}

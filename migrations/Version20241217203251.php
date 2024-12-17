<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217203251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE modified_profile_image (id INT AUTO_INCREMENT NOT NULL, modify_user_id INT NOT NULL, image_path VARCHAR(255) NOT NULL, uploaded_at DATETIME NOT NULL, INDEX IDX_DF945FF5F52F9A2C (modify_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE modified_profile_image ADD CONSTRAINT FK_DF945FF5F52F9A2C FOREIGN KEY (modify_user_id) REFERENCES modify_user (id)');
        $this->addSql('ALTER TABLE modify_user ADD new_password VARCHAR(255) DEFAULT NULL, DROP image, DROP password');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE modified_profile_image DROP FOREIGN KEY FK_DF945FF5F52F9A2C');
        $this->addSql('DROP TABLE modified_profile_image');
        $this->addSql('ALTER TABLE modify_user ADD password VARCHAR(255) DEFAULT NULL, CHANGE new_password image VARCHAR(255) DEFAULT NULL');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241214172347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_subscription (user_id INT NOT NULL, subscription_id INT NOT NULL, INDEX IDX_F08242DFA76ED395 (user_id), INDEX IDX_F08242DF9A1887DC (subscription_id), PRIMARY KEY(user_id, subscription_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_subscription ADD CONSTRAINT FK_F08242DFA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_subscription ADD CONSTRAINT FK_F08242DF9A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E99A1887DC');
        $this->addSql('DROP INDEX IDX_1483A5E99A1887DC ON users');
        $this->addSql('ALTER TABLE users DROP subscription_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_subscription DROP FOREIGN KEY FK_F08242DFA76ED395');
        $this->addSql('ALTER TABLE users_subscription DROP FOREIGN KEY FK_F08242DF9A1887DC');
        $this->addSql('DROP TABLE users_subscription');
        $this->addSql('ALTER TABLE users ADD subscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E99A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E99A1887DC ON users (subscription_id)');
    }
}

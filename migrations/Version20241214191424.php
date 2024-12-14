<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241214191424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO subscription (name, price, type) VALUES ('Abonnement Mensuel', 23.99, 'Mensuel')");
        $this->addSql("INSERT INTO subscription (name, price, type) VALUES ('Abonnement Annuel', ROUND(23.99 * 12 * 0.9, 2), 'Annuel')");
    }

    public function down(Schema $schema): void
    {

        $this->addSql('ALTER TABLE subscription DROP name, DROP price, DROP type');
        $this->addSql("DELETE FROM subscription WHERE name IN ('Abonnement Mensuel', 'Abonnement Annuel')");
    }
}

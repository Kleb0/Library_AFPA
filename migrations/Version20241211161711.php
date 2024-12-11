<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211161711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Recréer la table role avec les colonnes role_id et role_name, et insérer les rôles User et Admin';
    }

    public function up(Schema $schema): void
    {
        // Création de la table role
        $this->addSql('CREATE TABLE role (role_id INT AUTO_INCREMENT NOT NULL, rolename VARCHAR(255) NOT NULL, UNIQUE(rolename), PRIMARY KEY(role_id))');

        // Insertion des rôles par défaut
        $this->addSql("INSERT INTO role (role_id, rolename) VALUES (1, 'User')");
        $this->addSql("INSERT INTO role (role_id, rolename) VALUES (2, 'Admin')");
    }

    public function down(Schema $schema): void
    {
        // Suppression de la table role
        $this->addSql('DROP TABLE role');
    }
}

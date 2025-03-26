<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20241002134630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Créer les tables User, Groupe et la table de liaison groupe_user';
    }

    public function up(Schema $schema): void
    {
        // Créer la table User
        $this->addSql('CREATE TABLE `user` (
            `id` INT NOT NULL AUTO_INCREMENT, 
            `nom` VARCHAR(255) NOT NULL, 
            `prenom` VARCHAR(255) NOT NULL, 
            `email` VARCHAR(255) NOT NULL, 
            `password` VARCHAR(255) NOT NULL, 
            PRIMARY KEY(id)
        )');

        // Créer la table Groupe
        $this->addSql('CREATE TABLE `groupe` (
            `id` INT NOT NULL AUTO_INCREMENT, 
            `nom` VARCHAR(255) NOT NULL, 
            PRIMARY KEY(id)
        )');

        // Créer la table de liaison entre User et Groupe (groupe_user)
        $this->addSql('CREATE TABLE `groupe_user` (
            `user_id` INT NOT NULL, 
            `groupe_id` INT NOT NULL, 
            PRIMARY KEY(user_id, groupe_id), 
            CONSTRAINT FK_user FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE,
            CONSTRAINT FK_groupe FOREIGN KEY (groupe_id) REFERENCES `groupe` (id) ON DELETE CASCADE
        )');

        // Créer la table Conge
        $this->addSql('CREATE TABLE `conge` (
            `id` INT NOT NULL AUTO_INCREMENT, 
            `user_id` INT NOT NULL, 
            `type` VARCHAR(255) NOT NULL, 
            `date_debut` DATETIME NOT NULL, 
            `date_fin` DATETIME NOT NULL, 
            `statut` VARCHAR(255) NOT NULL, 
            PRIMARY KEY(id), 
            CONSTRAINT FK_user_conge FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE
        )');

        // Créer l'index sur la table Conge
        $this->addSql('CREATE INDEX IDX_2ED89348A76ED395 ON `conge` (user_id)');
    }

    public function down(Schema $schema): void
    {
        // Supprimer la table de liaison groupe_user
        $this->addSql('DROP TABLE `groupe_user`');

        // Supprimer la table Conge
        $this->addSql('DROP TABLE `conge`');

        // Supprimer la table Groupe
        $this->addSql('DROP TABLE `groupe`');

        // Supprimer la table User
        $this->addSql('DROP TABLE `user`');
    }
}

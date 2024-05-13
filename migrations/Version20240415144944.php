<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415144944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE films (id INT AUTO_INCREMENT NOT NULL, genre_id INT NOT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, duree TIME NOT NULL, date_de_sortie DATE NOT NULL, description LONGTEXT DEFAULT NULL, acteur_principale VARCHAR(255) NOT NULL, realisateur VARCHAR(255) NOT NULL, bande_annonce VARCHAR(255) DEFAULT NULL, INDEX IDX_CEECCA514296D31F (genre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre_membre (genre_id INT NOT NULL, membre_id INT NOT NULL, INDEX IDX_1D07CB094296D31F (genre_id), INDEX IDX_1D07CB096A99F74A (membre_id), PRIMARY KEY(genre_id, membre_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre_films (membre_id INT NOT NULL, films_id INT NOT NULL, INDEX IDX_78CAC5D06A99F74A (membre_id), INDEX IDX_78CAC5D0939610EE (films_id), PRIMARY KEY(membre_id, films_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE films ADD CONSTRAINT FK_CEECCA514296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE genre_membre ADD CONSTRAINT FK_1D07CB094296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genre_membre ADD CONSTRAINT FK_1D07CB096A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_films ADD CONSTRAINT FK_78CAC5D06A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membre_films ADD CONSTRAINT FK_78CAC5D0939610EE FOREIGN KEY (films_id) REFERENCES films (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre_films DROP FOREIGN KEY FK_78CAC5D0939610EE');
        $this->addSql('ALTER TABLE films DROP FOREIGN KEY FK_CEECCA514296D31F');
        $this->addSql('ALTER TABLE genre_membre DROP FOREIGN KEY FK_1D07CB094296D31F');
        $this->addSql('ALTER TABLE genre_membre DROP FOREIGN KEY FK_1D07CB096A99F74A');
        $this->addSql('ALTER TABLE membre_films DROP FOREIGN KEY FK_78CAC5D06A99F74A');
        $this->addSql('DROP TABLE films');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE genre_membre');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE membre_films');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

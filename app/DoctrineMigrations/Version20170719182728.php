<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170719182728 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cast_and_crew (id INT AUTO_INCREMENT NOT NULL, person_id INT DEFAULT NULL, movie_id INT DEFAULT NULL, role VARCHAR(80) NOT NULL, INDEX IDX_7CD052A7217BBB47 (person_id), INDEX IDX_7CD052A78F93B6FC (movie_id), UNIQUE INDEX person_movie_role_unique (person_id, movie_id, role), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(175) NOT NULL, release_year INT NOT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX tile_release_year_unique (title, release_year), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cast_and_crew ADD CONSTRAINT FK_7CD052A7217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE cast_and_crew ADD CONSTRAINT FK_7CD052A78F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cast_and_crew DROP FOREIGN KEY FK_7CD052A78F93B6FC');
        $this->addSql('ALTER TABLE cast_and_crew DROP FOREIGN KEY FK_7CD052A7217BBB47');
        $this->addSql('DROP TABLE cast_and_crew');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE person');
    }
}

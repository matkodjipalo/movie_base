<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180307183929 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE movie_cast_member (id INT AUTO_INCREMENT NOT NULL, person_id INT DEFAULT NULL, movie_id INT DEFAULT NULL, role VARCHAR(80) NOT NULL, INDEX IDX_469D0093217BBB47 (person_id), INDEX IDX_469D00938F93B6FC (movie_id), UNIQUE INDEX person_movie_role_unique (person_id, movie_id, role), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movie_cast_member ADD CONSTRAINT FK_469D0093217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE movie_cast_member ADD CONSTRAINT FK_469D00938F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('DROP TABLE cast_and_crew');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cast_and_crew (id INT AUTO_INCREMENT NOT NULL, person_id INT DEFAULT NULL, movie_id INT DEFAULT NULL, role VARCHAR(80) NOT NULL COLLATE utf8mb4_unicode_ci, UNIQUE INDEX person_movie_role_unique (person_id, movie_id, role), INDEX IDX_7CD052A7217BBB47 (person_id), INDEX IDX_7CD052A78F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cast_and_crew ADD CONSTRAINT FK_7CD052A7217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE cast_and_crew ADD CONSTRAINT FK_7CD052A78F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('DROP TABLE movie_cast_member');
    }
}

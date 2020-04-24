<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200424174840 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE resumes (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, area VARCHAR(255) NOT NULL, education VARCHAR(255) NOT NULL, salary DOUBLE PRECISION NOT NULL, experience INT NOT NULL, languages LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', is_main TINYINT(1) NOT NULL, about_you LONGTEXT NOT NULL, users_to_hide LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_CDB8AD33A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(191) NOT NULL, email VARCHAR(191) NOT NULL, password VARCHAR(191) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credits INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_num VARCHAR(255) NOT NULL, main_num INT DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), UNIQUE INDEX UNIQ_1483A5E935C246D5 (password), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resumes ADD CONSTRAINT FK_CDB8AD33A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tracking CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tracking ADD CONSTRAINT FK_A87C621CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE resumes DROP FOREIGN KEY FK_CDB8AD33A76ED395');
        $this->addSql('ALTER TABLE tracking DROP FOREIGN KEY FK_A87C621CA76ED395');
        $this->addSql('DROP TABLE resumes');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE tracking CHANGE user_id user_id INT DEFAULT NULL');
    }
}

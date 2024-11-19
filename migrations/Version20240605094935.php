<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605094935 extends AbstractMigration
{public function up(Schema $schema): void
{
    // this up() migration is auto-generated, please modify it to your needs
    $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, created_at 
    DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, question_id INT DEFAULT NULL, user_id INT DEFAULT NULL, 
    INDEX IDX_DADD4A251E27F6BF (question_id), INDEX IDX_DADD4A25A76ED395 (user_id), PRIMARY KEY(id)) 
    DEFAULT CHARACTER SET utf8mb4');
    $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, 
    summary VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, 
    updated_at DATETIME DEFAULT NULL, picture VARCHAR(400) DEFAULT NULL, user_id INT DEFAULT NULL, 
    category_id INT DEFAULT NULL, status_id INT NOT NULL, INDEX IDX_23A0E66A76ED395 (user_id), 
    INDEX IDX_23A0E6612469DE2 (category_id), INDEX IDX_23A0E666BF700BD (status_id), 
    PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, 
    home_order INT NOT NULL, picture VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, 
    PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) 
    DEFAULT CHARACTER SET utf8mb4');
    $this->addSql('CREATE TABLE pinpoint (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, 
    created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, latitude DOUBLE PRECISION NOT NULL, 
    longitude DOUBLE PRECISION NOT NULL, type_id INT NOT NULL, user_id INT DEFAULT NULL, 
    INDEX IDX_94252DDCC54C8C93 (type_id), INDEX IDX_94252DDCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, 
    content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, user_id INT DEFAULT NULL, 
    INDEX IDX_B6F7494EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, count INT NOT NULL, date DATETIME NOT NULL, 
    search_notice_id INT DEFAULT NULL, city_id INT DEFAULT NULL, INDEX IDX_C42F7784BCCE5003 (search_notice_id), 
    INDEX IDX_C42F77848BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    $this->addSql('CREATE TABLE search_notice (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(64) NOT NULL, 
    lastname VARCHAR(64) NOT NULL, home VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, age INT DEFAULT NULL, 
    picture VARCHAR(255) DEFAULT NULL, status INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, 
    latest_city VARCHAR(255) DEFAULT NULL, latest_date DATETIME DEFAULT NULL, user_id INT DEFAULT NULL, 
    INDEX IDX_91EF2ADDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, 
    PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, 
    icon_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, 
    password VARCHAR(255) NOT NULL, firstname VARCHAR(64) NOT NULL, lastname VARCHAR(64) NOT NULL, 
    UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
    $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
    $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE SET NULL');
    $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E666BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
    $this->addSql('ALTER TABLE pinpoint ADD CONSTRAINT FK_94252DDCC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE pinpoint ADD CONSTRAINT FK_94252DDCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
    $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
    $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784BCCE5003 FOREIGN KEY (search_notice_id) REFERENCES search_notice (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F77848BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE search_notice ADD CONSTRAINT FK_91EF2ADDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
}
    public function getDescription(): string
    {
        return '';
    }



    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25A76ED395');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E666BF700BD');
        $this->addSql('ALTER TABLE pinpoint DROP FOREIGN KEY FK_94252DDCC54C8C93');
        $this->addSql('ALTER TABLE pinpoint DROP FOREIGN KEY FK_94252DDCA76ED395');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EA76ED395');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784BCCE5003');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F77848BAC62AF');
        $this->addSql('ALTER TABLE search_notice DROP FOREIGN KEY FK_91EF2ADDA76ED395');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE pinpoint');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE search_notice');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}

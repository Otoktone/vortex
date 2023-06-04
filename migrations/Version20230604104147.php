<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230604104147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_favorite_articles (user_id INT NOT NULL, feed_article_id INT NOT NULL, INDEX IDX_ED9592B2A76ED395 (user_id), INDEX IDX_ED9592B2FDB98A80 (feed_article_id), PRIMARY KEY(user_id, feed_article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_favorite_articles ADD CONSTRAINT FK_ED9592B2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_favorite_articles ADD CONSTRAINT FK_ED9592B2FDB98A80 FOREIGN KEY (feed_article_id) REFERENCES feed_article (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_favorite_articles DROP FOREIGN KEY FK_ED9592B2A76ED395');
        $this->addSql('ALTER TABLE user_favorite_articles DROP FOREIGN KEY FK_ED9592B2FDB98A80');
        $this->addSql('DROP TABLE user_favorite_articles');
    }
}

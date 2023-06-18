<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618123312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feed_article_category (feed_article_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_5A71E915FDB98A80 (feed_article_id), INDEX IDX_5A71E91512469DE2 (category_id), PRIMARY KEY(feed_article_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feed_article_category ADD CONSTRAINT FK_5A71E915FDB98A80 FOREIGN KEY (feed_article_id) REFERENCES feed_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feed_article_category ADD CONSTRAINT FK_5A71E91512469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feed_article_category DROP FOREIGN KEY FK_5A71E915FDB98A80');
        $this->addSql('ALTER TABLE feed_article_category DROP FOREIGN KEY FK_5A71E91512469DE2');
        $this->addSql('DROP TABLE feed_article_category');
    }
}

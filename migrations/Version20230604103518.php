<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230604103518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_feed_article DROP FOREIGN KEY FK_38E46611A76ED395');
        $this->addSql('ALTER TABLE user_feed_article DROP FOREIGN KEY FK_38E46611FDB98A80');
        $this->addSql('DROP TABLE user_feed_article');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_feed_article (user_id INT NOT NULL, feed_article_id INT NOT NULL, INDEX IDX_38E46611FDB98A80 (feed_article_id), INDEX IDX_38E46611A76ED395 (user_id), PRIMARY KEY(user_id, feed_article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_feed_article ADD CONSTRAINT FK_38E46611A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_feed_article ADD CONSTRAINT FK_38E46611FDB98A80 FOREIGN KEY (feed_article_id) REFERENCES feed_article (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}

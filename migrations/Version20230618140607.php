<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618140607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feed_article DROP FOREIGN KEY FK_B8281A1312469DE2');
        $this->addSql('DROP INDEX IDX_B8281A1312469DE2 ON feed_article');
        $this->addSql('ALTER TABLE feed_article ADD category VARCHAR(255) DEFAULT NULL, DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feed_article ADD category_id INT DEFAULT NULL, DROP category');
        $this->addSql('ALTER TABLE feed_article ADD CONSTRAINT FK_B8281A1312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B8281A1312469DE2 ON feed_article (category_id)');
    }
}

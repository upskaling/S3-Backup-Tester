<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205091443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bucket AS SELECT id, name, endpoint, region, credentials_key, credentials_secret FROM bucket');
        $this->addSql('DROP TABLE bucket');
        $this->addSql('CREATE TABLE bucket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, endpoint VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, credentials_key VARCHAR(255) NOT NULL, credentials_secret VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO bucket (id, name, endpoint, region, credentials_key, credentials_secret) SELECT id, name, endpoint, region, credentials_key, credentials_secret FROM __temp__bucket');
        $this->addSql('DROP TABLE __temp__bucket');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bucket ADD COLUMN options CLOB NOT NULL');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205091155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bucket ADD COLUMN endpoint VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE bucket ADD COLUMN region VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE bucket ADD COLUMN credentials_key VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE bucket ADD COLUMN credentials_secret VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bucket AS SELECT id, name, options FROM bucket');
        $this->addSql('DROP TABLE bucket');
        $this->addSql('CREATE TABLE bucket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, options CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO bucket (id, name, options) SELECT id, name, options FROM __temp__bucket');
        $this->addSql('DROP TABLE __temp__bucket');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205121341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bucket_test (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bucket_id INTEGER DEFAULT NULL, interval VARCHAR(255) NOT NULL --(DC2Type:dateinterval)
        , CONSTRAINT FK_917504DA84CE584D FOREIGN KEY (bucket_id) REFERENCES bucket (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_917504DA84CE584D ON bucket_test (bucket_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bucket AS SELECT id, name, endpoint, region, credentials_key, credentials_secret FROM bucket');
        $this->addSql('DROP TABLE bucket');
        $this->addSql('CREATE TABLE bucket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, endpoint VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, credentials_key VARCHAR(255) NOT NULL, credentials_secret VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO bucket (id, name, endpoint, region, credentials_key, credentials_secret) SELECT id, name, endpoint, region, credentials_key, credentials_secret FROM __temp__bucket');
        $this->addSql('DROP TABLE __temp__bucket');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E73F36A65E237E06 ON bucket (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bucket_test');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bucket AS SELECT id, name, endpoint, region, credentials_key, credentials_secret FROM bucket');
        $this->addSql('DROP TABLE bucket');
        $this->addSql('CREATE TABLE bucket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, endpoint VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, credentials_key VARCHAR(255) NOT NULL, credentials_secret VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO bucket (id, name, endpoint, region, credentials_key, credentials_secret) SELECT id, name, endpoint, region, credentials_key, credentials_secret FROM __temp__bucket');
        $this->addSql('DROP TABLE __temp__bucket');
    }
}

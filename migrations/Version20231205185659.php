<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205185659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE incident ADD COLUMN path VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__incident AS SELECT id, bucket_id, created_at, status, message FROM incident');
        $this->addSql('DROP TABLE incident');
        $this->addSql('CREATE TABLE incident (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bucket_id INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , status VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, CONSTRAINT FK_3D03A11A84CE584D FOREIGN KEY (bucket_id) REFERENCES bucket (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO incident (id, bucket_id, created_at, status, message) SELECT id, bucket_id, created_at, status, message FROM __temp__incident');
        $this->addSql('DROP TABLE __temp__incident');
        $this->addSql('CREATE INDEX IDX_3D03A11A84CE584D ON incident (bucket_id)');
    }
}

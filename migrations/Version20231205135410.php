<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205135410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bucket_test AS SELECT id, bucket_id, interval FROM bucket_test');
        $this->addSql('DROP TABLE bucket_test');
        $this->addSql('CREATE TABLE bucket_test (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bucket_id INTEGER DEFAULT NULL, interval INTEGER NOT NULL, CONSTRAINT FK_917504DA84CE584D FOREIGN KEY (bucket_id) REFERENCES bucket (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO bucket_test (id, bucket_id, interval) SELECT id, bucket_id, interval FROM __temp__bucket_test');
        $this->addSql('DROP TABLE __temp__bucket_test');
        $this->addSql('CREATE INDEX IDX_917504DA84CE584D ON bucket_test (bucket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bucket_test AS SELECT id, bucket_id, interval FROM bucket_test');
        $this->addSql('DROP TABLE bucket_test');
        $this->addSql('CREATE TABLE bucket_test (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bucket_id INTEGER DEFAULT NULL, interval VARCHAR(255) NOT NULL --(DC2Type:dateinterval)
        , CONSTRAINT FK_917504DA84CE584D FOREIGN KEY (bucket_id) REFERENCES bucket (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO bucket_test (id, bucket_id, interval) SELECT id, bucket_id, interval FROM __temp__bucket_test');
        $this->addSql('DROP TABLE __temp__bucket_test');
        $this->addSql('CREATE INDEX IDX_917504DA84CE584D ON bucket_test (bucket_id)');
    }
}

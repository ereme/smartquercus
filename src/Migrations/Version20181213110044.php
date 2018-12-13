<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181213110044 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evento ADD ayuntamiento_id INT NOT NULL');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B051A68224 FOREIGN KEY (ayuntamiento_id) REFERENCES app_users (id)');
        $this->addSql('CREATE INDEX IDX_47860B051A68224 ON evento (ayuntamiento_id)');
        $this->addSql('ALTER TABLE imagen CHANGE nombre nombre VARCHAR(255) DEFAULT NULL, CHANGE original original VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evento DROP FOREIGN KEY FK_47860B051A68224');
        $this->addSql('DROP INDEX IDX_47860B051A68224 ON evento');
        $this->addSql('ALTER TABLE evento DROP ayuntamiento_id');
        $this->addSql('ALTER TABLE imagen CHANGE nombre nombre VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE original original VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}

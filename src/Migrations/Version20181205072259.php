<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181205072259 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE opina CHANGE fechahoralimite fechahoralimite DATE NOT NULL');
        $this->addSql('ALTER TABLE incidencia DROP FOREIGN KEY FK_C7C6728C1A68224');
        $this->addSql('DROP INDEX IDX_C7C6728C1A68224 ON incidencia');
        $this->addSql('ALTER TABLE incidencia DROP ayuntamiento_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incidencia ADD ayuntamiento_id INT NOT NULL');
        $this->addSql('ALTER TABLE incidencia ADD CONSTRAINT FK_C7C6728C1A68224 FOREIGN KEY (ayuntamiento_id) REFERENCES app_users (id)');
        $this->addSql('CREATE INDEX IDX_C7C6728C1A68224 ON incidencia (ayuntamiento_id)');
        $this->addSql('ALTER TABLE opina CHANGE fechahoralimite fechahoralimite DATETIME NOT NULL');
    }
}

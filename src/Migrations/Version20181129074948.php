<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181129074948 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE imagen ADD opina_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE imagen ADD CONSTRAINT FK_8319D2B393E2A6AF FOREIGN KEY (opina_id) REFERENCES opina (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8319D2B393E2A6AF ON imagen (opina_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE imagen DROP FOREIGN KEY FK_8319D2B393E2A6AF');
        $this->addSql('DROP INDEX UNIQ_8319D2B393E2A6AF ON imagen');
        $this->addSql('ALTER TABLE imagen DROP opina_id');
    }
}

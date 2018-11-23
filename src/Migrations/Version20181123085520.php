<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181123085520 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE telefono (id INT AUTO_INCREMENT NOT NULL, aytoid_id INT NOT NULL, nombre VARCHAR(100) NOT NULL, telefono VARCHAR(9) NOT NULL, INDEX IDX_C1E70A7F46ED2B0F (aytoid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opina (id INT AUTO_INCREMENT NOT NULL, pregunta VARCHAR(255) NOT NULL, votosfavor INT NOT NULL, votoscontra INT NOT NULL, fechahoralimite DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ayuntamiento (id INT AUTO_INCREMENT NOT NULL, imagenescudo VARCHAR(255) NOT NULL, localidad VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE telefono ADD CONSTRAINT FK_C1E70A7F46ED2B0F FOREIGN KEY (aytoid_id) REFERENCES ayuntamiento (id)');
        $this->addSql('ALTER TABLE incidencia ADD estado VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE telefono DROP FOREIGN KEY FK_C1E70A7F46ED2B0F');
        $this->addSql('DROP TABLE telefono');
        $this->addSql('DROP TABLE opina');
        $this->addSql('DROP TABLE ayuntamiento');
        $this->addSql('ALTER TABLE incidencia DROP estado');
    }
}

<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181122123817 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE telefono (id INT AUTO_INCREMENT NOT NULL, aytoid_id INT NOT NULL, nombre VARCHAR(100) NOT NULL, telefono VARCHAR(9) NOT NULL, INDEX IDX_C1E70A7F46ED2B0F (aytoid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE telefono ADD CONSTRAINT FK_C1E70A7F46ED2B0F FOREIGN KEY (aytoid_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE app_users ADD imagenescudo VARCHAR(255) DEFAULT NULL, ADD localidad VARCHAR(100) DEFAULT NULL, CHANGE nombre nombre VARCHAR(255) DEFAULT NULL, CHANGE apellido1 apellido1 VARCHAR(255) DEFAULT NULL, CHANGE apellido2 apellido2 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE telefono');
        $this->addSql('ALTER TABLE app_users DROP imagenescudo, DROP localidad, CHANGE nombre nombre VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE apellido1 apellido1 VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE apellido2 apellido2 VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}

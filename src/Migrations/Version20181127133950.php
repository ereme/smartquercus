<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181127133950 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE salud DROP FOREIGN KEY FK_A290E7D2763C8AA7');
        $this->addSql('DROP TABLE imagen');
        $this->addSql('DROP TABLE noticias');
        $this->addSql('DROP TABLE salud');
        $this->addSql('ALTER TABLE opina DROP FOREIGN KEY FK_30B250551A68224');
        $this->addSql('DROP INDEX IDX_30B250551A68224 ON opina');
        $this->addSql('ALTER TABLE opina DROP ayuntamiento_id');
        $this->addSql('ALTER TABLE telefono DROP FOREIGN KEY FK_C1E70A7F6A97795E');
        $this->addSql('ALTER TABLE telefono DROP FOREIGN KEY FK_C1E70A7F46ED2B0F');
        $this->addSql('DROP INDEX IDX_C1E70A7F6A97795E ON telefono');
        $this->addSql('ALTER TABLE telefono CHANGE ayto_id aytoid_id INT NOT NULL');
        $this->addSql('ALTER TABLE telefono ADD CONSTRAINT FK_C1E70A7F46ED2B0F FOREIGN KEY (aytoid_id) REFERENCES ayuntamiento (id)');
        $this->addSql('CREATE INDEX IDX_C1E70A7F46ED2B0F ON telefono (aytoid_id)');
        $this->addSql('ALTER TABLE app_users DROP imagenescudo, DROP localidad, CHANGE nombre nombre VARCHAR(255) NOT NULL, CHANGE apellido1 apellido1 VARCHAR(255) NOT NULL, CHANGE apellido2 apellido2 VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE imagen (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, original VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noticias (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salud (id INT AUTO_INCREMENT NOT NULL, imagen_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, texto LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, fechahora DATE NOT NULL, UNIQUE INDEX UNIQ_A290E7D2763C8AA7 (imagen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE salud ADD CONSTRAINT FK_A290E7D2763C8AA7 FOREIGN KEY (imagen_id) REFERENCES imagen (id)');
        $this->addSql('ALTER TABLE app_users ADD imagenescudo VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD localidad VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE nombre nombre VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE apellido1 apellido1 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE apellido2 apellido2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE opina ADD ayuntamiento_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE opina ADD CONSTRAINT FK_30B250551A68224 FOREIGN KEY (ayuntamiento_id) REFERENCES app_users (id)');
        $this->addSql('CREATE INDEX IDX_30B250551A68224 ON opina (ayuntamiento_id)');
        $this->addSql('ALTER TABLE telefono DROP FOREIGN KEY FK_C1E70A7F46ED2B0F');
        $this->addSql('DROP INDEX IDX_C1E70A7F46ED2B0F ON telefono');
        $this->addSql('ALTER TABLE telefono CHANGE aytoid_id ayto_id INT NOT NULL');
        $this->addSql('ALTER TABLE telefono ADD CONSTRAINT FK_C1E70A7F6A97795E FOREIGN KEY (ayto_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE telefono ADD CONSTRAINT FK_C1E70A7F46ED2B0F FOREIGN KEY (ayto_id) REFERENCES ayuntamiento (id)');
        $this->addSql('CREATE INDEX IDX_C1E70A7F6A97795E ON telefono (ayto_id)');
    }
}

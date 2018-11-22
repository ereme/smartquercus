<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180908063911 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE equipo (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, nombre VARCHAR(255) NOT NULL, capacidad INT DEFAULT NULL, roma VARCHAR(7) DEFAULT NULL, fecha_adquisicion DATE DEFAULT NULL, fecha_ultima_inspeccion DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE variedad_parcela');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE variedad_parcela (variedad_id INT NOT NULL, parcela_id INT NOT NULL, INDEX IDX_C21E93EB91391A54 (variedad_id), INDEX IDX_C21E93EB1491307D (parcela_id), PRIMARY KEY(variedad_id, parcela_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE variedad_parcela ADD CONSTRAINT FK_C21E93EB1491307D FOREIGN KEY (parcela_id) REFERENCES parcela (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variedad_parcela ADD CONSTRAINT FK_C21E93EB91391A54 FOREIGN KEY (variedad_id) REFERENCES variedad (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE equipo');
    }
}

<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181212093916 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE evento (id INT AUTO_INCREMENT NOT NULL, imagen_id INT DEFAULT NULL, titular VARCHAR(100) NOT NULL, fechahora DATETIME NOT NULL, texto LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_47860B05763C8AA7 (imagen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B05763C8AA7 FOREIGN KEY (imagen_id) REFERENCES imagen (id)');
        $this->addSql('ALTER TABLE imagen DROP incidencia_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE evento');
        $this->addSql('ALTER TABLE imagen ADD incidencia_id INT NOT NULL');
    }
}

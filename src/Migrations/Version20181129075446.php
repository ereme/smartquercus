<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181129075446 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE salud ADD imagen_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salud ADD CONSTRAINT FK_A290E7D2763C8AA7 FOREIGN KEY (imagen_id) REFERENCES imagen (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A290E7D2763C8AA7 ON salud (imagen_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE salud DROP FOREIGN KEY FK_A290E7D2763C8AA7');
        $this->addSql('DROP INDEX UNIQ_A290E7D2763C8AA7 ON salud');
        $this->addSql('ALTER TABLE salud DROP imagen_id');
    }
}

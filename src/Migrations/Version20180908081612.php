<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180908081612 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tratamiento ADD producto_id INT NOT NULL');
        $this->addSql('ALTER TABLE tratamiento ADD CONSTRAINT FK_61A4A07C7645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('CREATE INDEX IDX_61A4A07C7645698E ON tratamiento (producto_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tratamiento DROP FOREIGN KEY FK_61A4A07C7645698E');
        $this->addSql('DROP INDEX IDX_61A4A07C7645698E ON tratamiento');
        $this->addSql('ALTER TABLE tratamiento DROP producto_id');
    }
}

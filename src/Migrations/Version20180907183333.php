<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180907183333 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parcela DROP FOREIGN KEY FK_A5CC44465F21A0D9');
        $this->addSql('DROP INDEX IDX_A5CC44465F21A0D9 ON parcela');
        $this->addSql('ALTER TABLE parcela DROP cultivo_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parcela ADD cultivo_id INT NOT NULL');
        $this->addSql('ALTER TABLE parcela ADD CONSTRAINT FK_A5CC44465F21A0D9 FOREIGN KEY (cultivo_id) REFERENCES cultivo (id)');
        $this->addSql('CREATE INDEX IDX_A5CC44465F21A0D9 ON parcela (cultivo_id)');
    }
}

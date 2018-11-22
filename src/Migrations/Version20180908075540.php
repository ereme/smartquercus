<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180908075540 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tratamiento_parcela (tratamiento_id INT NOT NULL, parcela_id INT NOT NULL, INDEX IDX_4B0FFF8F44168F7D (tratamiento_id), INDEX IDX_4B0FFF8F1491307D (parcela_id), PRIMARY KEY(tratamiento_id, parcela_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plaga (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plaga_cultivo (plaga_id INT NOT NULL, cultivo_id INT NOT NULL, INDEX IDX_47E70C687744938E (plaga_id), INDEX IDX_47E70C685F21A0D9 (cultivo_id), PRIMARY KEY(plaga_id, cultivo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tratamiento_parcela ADD CONSTRAINT FK_4B0FFF8F44168F7D FOREIGN KEY (tratamiento_id) REFERENCES tratamiento (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tratamiento_parcela ADD CONSTRAINT FK_4B0FFF8F1491307D FOREIGN KEY (parcela_id) REFERENCES parcela (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plaga_cultivo ADD CONSTRAINT FK_47E70C687744938E FOREIGN KEY (plaga_id) REFERENCES plaga (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plaga_cultivo ADD CONSTRAINT FK_47E70C685F21A0D9 FOREIGN KEY (cultivo_id) REFERENCES cultivo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tratamiento ADD plaga_id INT NOT NULL, ADD equipo_id INT NOT NULL');
        $this->addSql('ALTER TABLE tratamiento ADD CONSTRAINT FK_61A4A07C7744938E FOREIGN KEY (plaga_id) REFERENCES plaga (id)');
        $this->addSql('ALTER TABLE tratamiento ADD CONSTRAINT FK_61A4A07C23BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id)');
        $this->addSql('CREATE INDEX IDX_61A4A07C7744938E ON tratamiento (plaga_id)');
        $this->addSql('CREATE INDEX IDX_61A4A07C23BFBED ON tratamiento (equipo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tratamiento DROP FOREIGN KEY FK_61A4A07C7744938E');
        $this->addSql('ALTER TABLE plaga_cultivo DROP FOREIGN KEY FK_47E70C687744938E');
        $this->addSql('DROP TABLE tratamiento_parcela');
        $this->addSql('DROP TABLE plaga');
        $this->addSql('DROP TABLE plaga_cultivo');
        $this->addSql('ALTER TABLE tratamiento DROP FOREIGN KEY FK_61A4A07C23BFBED');
        $this->addSql('DROP INDEX IDX_61A4A07C7744938E ON tratamiento');
        $this->addSql('DROP INDEX IDX_61A4A07C23BFBED ON tratamiento');
        $this->addSql('ALTER TABLE tratamiento DROP plaga_id, DROP equipo_id');
    }
}

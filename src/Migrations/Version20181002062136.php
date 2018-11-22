<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181002062136 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE participacion (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, explotacion_id INT NOT NULL, rol VARCHAR(7) NOT NULL, INDEX IDX_669B8D69A76ED395 (user_id), INDEX IDX_669B8D691A6AAB04 (explotacion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participacion ADD CONSTRAINT FK_669B8D69A76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE participacion ADD CONSTRAINT FK_669B8D691A6AAB04 FOREIGN KEY (explotacion_id) REFERENCES explotacion (id)');
        $this->addSql('DROP TABLE user_explotacion');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_explotacion (user_id INT NOT NULL, explotacion_id INT NOT NULL, INDEX IDX_1E834F1DA76ED395 (user_id), INDEX IDX_1E834F1D1A6AAB04 (explotacion_id), PRIMARY KEY(user_id, explotacion_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_explotacion ADD CONSTRAINT FK_1E834F1D1A6AAB04 FOREIGN KEY (explotacion_id) REFERENCES explotacion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_explotacion ADD CONSTRAINT FK_1E834F1DA76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE participacion');
    }
}

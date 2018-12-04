<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181204075250 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, imagen_id INT DEFAULT NULL, ayuntamiento_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', is_active TINYINT(1) NOT NULL, discr VARCHAR(255) NOT NULL, localidad VARCHAR(100) DEFAULT NULL, nombre VARCHAR(255) DEFAULT NULL, apellido1 VARCHAR(255) DEFAULT NULL, apellido2 VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_C2502824E7927C74 (email), UNIQUE INDEX UNIQ_C2502824F85E0677 (username), INDEX IDX_C2502824763C8AA7 (imagen_id), INDEX IDX_C25028241A68224 (ayuntamiento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opina (id INT AUTO_INCREMENT NOT NULL, ayuntamiento_id INT NOT NULL, imagen_id INT DEFAULT NULL, pregunta VARCHAR(255) NOT NULL, votosfavor INT NOT NULL, votoscontra INT NOT NULL, fechahoralimite DATETIME NOT NULL, INDEX IDX_30B250551A68224 (ayuntamiento_id), UNIQUE INDEX UNIQ_30B25055763C8AA7 (imagen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salud (id INT AUTO_INCREMENT NOT NULL, imagen_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, texto LONGTEXT NOT NULL, fechahora DATE NOT NULL, UNIQUE INDEX UNIQ_A290E7D2763C8AA7 (imagen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noticias (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plaga (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plaga_cultivo (plaga_id INT NOT NULL, cultivo_id INT NOT NULL, INDEX IDX_47E70C687744938E (plaga_id), INDEX IDX_47E70C685F21A0D9 (cultivo_id), PRIMARY KEY(plaga_id, cultivo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cultivo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localidad (id INT AUTO_INCREMENT NOT NULL, provincia_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_4F68E0104E7121AF (provincia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE explotacion (id INT AUTO_INCREMENT NOT NULL, rexa VARCHAR(20) NOT NULL, roppi VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provincia (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE imagen (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, original VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tratamiento (id INT AUTO_INCREMENT NOT NULL, plaga_id INT NOT NULL, equipo_id INT NOT NULL, producto_id INT NOT NULL, registro INT NOT NULL, dosis_recomendada NUMERIC(7, 4) NOT NULL, unidades VARCHAR(5) NOT NULL, num_aplicaciones INT NOT NULL, dosis_empleada NUMERIC(7, 4) NOT NULL, INDEX IDX_61A4A07C7744938E (plaga_id), INDEX IDX_61A4A07C23BFBED (equipo_id), INDEX IDX_61A4A07C7645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tratamiento_parcela (tratamiento_id INT NOT NULL, parcela_id INT NOT NULL, INDEX IDX_4B0FFF8F44168F7D (tratamiento_id), INDEX IDX_4B0FFF8F1491307D (parcela_id), PRIMARY KEY(tratamiento_id, parcela_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telefono (id INT AUTO_INCREMENT NOT NULL, ayto_id INT NOT NULL, nombre VARCHAR(100) NOT NULL, telefono VARCHAR(9) NOT NULL, INDEX IDX_C1E70A7F6A97795E (ayto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, principio VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participacion (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, explotacion_id INT NOT NULL, rol VARCHAR(7) NOT NULL, INDEX IDX_669B8D69A76ED395 (user_id), INDEX IDX_669B8D691A6AAB04 (explotacion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variedad (id INT AUTO_INCREMENT NOT NULL, cultivo_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_850B22B35F21A0D9 (cultivo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sigpac_uso (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcela (id INT AUTO_INCREMENT NOT NULL, localidad_id INT NOT NULL, sigpac_uso_id INT NOT NULL, agrupacion_id INT NOT NULL, numid INT NOT NULL, poligono VARCHAR(3) NOT NULL, parcela VARCHAR(5) NOT NULL, recinto VARCHAR(2) NOT NULL, superficie NUMERIC(10, 4) NOT NULL, marco_plantacion VARCHAR(5) DEFAULT NULL, pi TINYINT(1) NOT NULL, piayuda TINYINT(1) NOT NULL, volumen_copa NUMERIC(4, 2) DEFAULT NULL, INDEX IDX_A5CC444667707C89 (localidad_id), INDEX IDX_A5CC4446ED2E5089 (sigpac_uso_id), INDEX IDX_A5CC4446162972A4 (agrupacion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcela_variedad (parcela_id INT NOT NULL, variedad_id INT NOT NULL, INDEX IDX_E9F8A4EB1491307D (parcela_id), INDEX IDX_E9F8A4EB91391A54 (variedad_id), PRIMARY KEY(parcela_id, variedad_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agrupacion (id INT AUTO_INCREMENT NOT NULL, explotacion_id INT NOT NULL, nombre VARCHAR(255) DEFAULT NULL, INDEX IDX_3C02427D1A6AAB04 (explotacion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipo (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, nombre VARCHAR(255) NOT NULL, capacidad INT DEFAULT NULL, roma VARCHAR(7) DEFAULT NULL, fecha_adquisicion DATE DEFAULT NULL, fecha_ultima_inspeccion DATE DEFAULT NULL, bastidor VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incidencia (id INT AUTO_INCREMENT NOT NULL, fecha DATE NOT NULL, latitud VARCHAR(255) NOT NULL, longitud VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, estado VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_users ADD CONSTRAINT FK_C2502824763C8AA7 FOREIGN KEY (imagen_id) REFERENCES imagen (id)');
        $this->addSql('ALTER TABLE app_users ADD CONSTRAINT FK_C25028241A68224 FOREIGN KEY (ayuntamiento_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE opina ADD CONSTRAINT FK_30B250551A68224 FOREIGN KEY (ayuntamiento_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE opina ADD CONSTRAINT FK_30B25055763C8AA7 FOREIGN KEY (imagen_id) REFERENCES imagen (id)');
        $this->addSql('ALTER TABLE salud ADD CONSTRAINT FK_A290E7D2763C8AA7 FOREIGN KEY (imagen_id) REFERENCES imagen (id)');
        $this->addSql('ALTER TABLE plaga_cultivo ADD CONSTRAINT FK_47E70C687744938E FOREIGN KEY (plaga_id) REFERENCES plaga (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plaga_cultivo ADD CONSTRAINT FK_47E70C685F21A0D9 FOREIGN KEY (cultivo_id) REFERENCES cultivo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE localidad ADD CONSTRAINT FK_4F68E0104E7121AF FOREIGN KEY (provincia_id) REFERENCES provincia (id)');
        $this->addSql('ALTER TABLE tratamiento ADD CONSTRAINT FK_61A4A07C7744938E FOREIGN KEY (plaga_id) REFERENCES plaga (id)');
        $this->addSql('ALTER TABLE tratamiento ADD CONSTRAINT FK_61A4A07C23BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id)');
        $this->addSql('ALTER TABLE tratamiento ADD CONSTRAINT FK_61A4A07C7645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE tratamiento_parcela ADD CONSTRAINT FK_4B0FFF8F44168F7D FOREIGN KEY (tratamiento_id) REFERENCES tratamiento (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tratamiento_parcela ADD CONSTRAINT FK_4B0FFF8F1491307D FOREIGN KEY (parcela_id) REFERENCES parcela (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE telefono ADD CONSTRAINT FK_C1E70A7F6A97795E FOREIGN KEY (ayto_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE participacion ADD CONSTRAINT FK_669B8D69A76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE participacion ADD CONSTRAINT FK_669B8D691A6AAB04 FOREIGN KEY (explotacion_id) REFERENCES explotacion (id)');
        $this->addSql('ALTER TABLE variedad ADD CONSTRAINT FK_850B22B35F21A0D9 FOREIGN KEY (cultivo_id) REFERENCES cultivo (id)');
        $this->addSql('ALTER TABLE parcela ADD CONSTRAINT FK_A5CC444667707C89 FOREIGN KEY (localidad_id) REFERENCES localidad (id)');
        $this->addSql('ALTER TABLE parcela ADD CONSTRAINT FK_A5CC4446ED2E5089 FOREIGN KEY (sigpac_uso_id) REFERENCES sigpac_uso (id)');
        $this->addSql('ALTER TABLE parcela ADD CONSTRAINT FK_A5CC4446162972A4 FOREIGN KEY (agrupacion_id) REFERENCES agrupacion (id)');
        $this->addSql('ALTER TABLE parcela_variedad ADD CONSTRAINT FK_E9F8A4EB1491307D FOREIGN KEY (parcela_id) REFERENCES parcela (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parcela_variedad ADD CONSTRAINT FK_E9F8A4EB91391A54 FOREIGN KEY (variedad_id) REFERENCES variedad (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agrupacion ADD CONSTRAINT FK_3C02427D1A6AAB04 FOREIGN KEY (explotacion_id) REFERENCES explotacion (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_users DROP FOREIGN KEY FK_C25028241A68224');
        $this->addSql('ALTER TABLE opina DROP FOREIGN KEY FK_30B250551A68224');
        $this->addSql('ALTER TABLE telefono DROP FOREIGN KEY FK_C1E70A7F6A97795E');
        $this->addSql('ALTER TABLE participacion DROP FOREIGN KEY FK_669B8D69A76ED395');
        $this->addSql('ALTER TABLE plaga_cultivo DROP FOREIGN KEY FK_47E70C687744938E');
        $this->addSql('ALTER TABLE tratamiento DROP FOREIGN KEY FK_61A4A07C7744938E');
        $this->addSql('ALTER TABLE plaga_cultivo DROP FOREIGN KEY FK_47E70C685F21A0D9');
        $this->addSql('ALTER TABLE variedad DROP FOREIGN KEY FK_850B22B35F21A0D9');
        $this->addSql('ALTER TABLE parcela DROP FOREIGN KEY FK_A5CC444667707C89');
        $this->addSql('ALTER TABLE participacion DROP FOREIGN KEY FK_669B8D691A6AAB04');
        $this->addSql('ALTER TABLE agrupacion DROP FOREIGN KEY FK_3C02427D1A6AAB04');
        $this->addSql('ALTER TABLE localidad DROP FOREIGN KEY FK_4F68E0104E7121AF');
        $this->addSql('ALTER TABLE app_users DROP FOREIGN KEY FK_C2502824763C8AA7');
        $this->addSql('ALTER TABLE opina DROP FOREIGN KEY FK_30B25055763C8AA7');
        $this->addSql('ALTER TABLE salud DROP FOREIGN KEY FK_A290E7D2763C8AA7');
        $this->addSql('ALTER TABLE tratamiento_parcela DROP FOREIGN KEY FK_4B0FFF8F44168F7D');
        $this->addSql('ALTER TABLE tratamiento DROP FOREIGN KEY FK_61A4A07C7645698E');
        $this->addSql('ALTER TABLE parcela_variedad DROP FOREIGN KEY FK_E9F8A4EB91391A54');
        $this->addSql('ALTER TABLE parcela DROP FOREIGN KEY FK_A5CC4446ED2E5089');
        $this->addSql('ALTER TABLE tratamiento_parcela DROP FOREIGN KEY FK_4B0FFF8F1491307D');
        $this->addSql('ALTER TABLE parcela_variedad DROP FOREIGN KEY FK_E9F8A4EB1491307D');
        $this->addSql('ALTER TABLE parcela DROP FOREIGN KEY FK_A5CC4446162972A4');
        $this->addSql('ALTER TABLE tratamiento DROP FOREIGN KEY FK_61A4A07C23BFBED');
        $this->addSql('DROP TABLE app_users');
        $this->addSql('DROP TABLE opina');
        $this->addSql('DROP TABLE salud');
        $this->addSql('DROP TABLE noticias');
        $this->addSql('DROP TABLE plaga');
        $this->addSql('DROP TABLE plaga_cultivo');
        $this->addSql('DROP TABLE cultivo');
        $this->addSql('DROP TABLE localidad');
        $this->addSql('DROP TABLE explotacion');
        $this->addSql('DROP TABLE provincia');
        $this->addSql('DROP TABLE imagen');
        $this->addSql('DROP TABLE tratamiento');
        $this->addSql('DROP TABLE tratamiento_parcela');
        $this->addSql('DROP TABLE telefono');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE participacion');
        $this->addSql('DROP TABLE variedad');
        $this->addSql('DROP TABLE sigpac_uso');
        $this->addSql('DROP TABLE parcela');
        $this->addSql('DROP TABLE parcela_variedad');
        $this->addSql('DROP TABLE agrupacion');
        $this->addSql('DROP TABLE equipo');
        $this->addSql('DROP TABLE incidencia');
    }
}

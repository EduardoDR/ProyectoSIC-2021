<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201121193159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE ajustes_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE insumos_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE insumos (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, costo DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE catalogo_de_cuentas');
        $this->addSql('DROP TABLE ajustes');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE insumos_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE ajustes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE catalogo_de_cuentas (numerocuenta VARCHAR(6) NOT NULL, nombrecuenta VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE ajustes (partidas_id INT DEFAULT NULL, numero VARCHAR(255) DEFAULT NULL, nombre VARCHAR(255) DEFAULT NULL, debe DOUBLE PRECISION DEFAULT NULL, haber DOUBLE PRECISION DEFAULT NULL, id INT DEFAULT NULL)');
        $this->addSql('DROP TABLE insumos');
    }
}

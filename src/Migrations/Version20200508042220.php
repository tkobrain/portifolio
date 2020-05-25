<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200508042220 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE aplicacao (Id INT AUTO_INCREMENT NOT NULL, Nome VARCHAR(255) NOT NULL, Descricao VARCHAR(255) DEFAULT NULL, PublicoAlvo VARCHAR(255) DEFAULT NULL, URLAcesso VARCHAR(255) DEFAULT NULL, URLAjuda VARCHAR(255) DEFAULT NULL, DataHomologacao DATETIME DEFAULT NULL, AreaResponsavel VARCHAR(255) DEFAULT NULL, UsuarioResponsavel VARCHAR(100) DEFAULT NULL, Ativo TINYINT(1) NOT NULL, Legado TINYINT(1) NOT NULL, PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE atividade (Id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', Descricao VARCHAR(255) NOT NULL, Pontos DOUBLE PRECISION NOT NULL, Tempo TIME DEFAULT NULL, Planejado TINYINT(1) NOT NULL, NumeroChamado INT DEFAULT NULL, DataChamado DATETIME DEFAULT NULL, Solicitante VARCHAR(60) DEFAULT NULL, RealizadoPor VARCHAR(60) DEFAULT NULL, Entrega TINYINT(1) DEFAULT NULL, IdAplicacao INT NOT NULL, IdSprint VARCHAR(10) NOT NULL, IdCategoriaAtividade INT NOT NULL, INDEX IDX_136416C2AEA802F6 (IdAplicacao), INDEX IDX_136416C275E79F7B (IdSprint), INDEX IDX_136416C2F41106DD (IdCategoriaAtividade), PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoria_atividade (Id INT AUTO_INCREMENT NOT NULL, Nome VARCHAR(255) NOT NULL, Descricao VARCHAR(255) DEFAULT NULL, Ativo TINYINT(1) NOT NULL, PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departamento (Id VARCHAR(10) NOT NULL, Descricao VARCHAR(100) NOT NULL, Responsavel VARCHAR(100) NOT NULL, Ativo TINYINT(1) NOT NULL, PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrega (Id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', Descricao VARCHAR(255) NOT NULL, Solicitante VARCHAR(100) DEFAULT NULL, Aprovado TINYINT(1) DEFAULT NULL, IdAtividade CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_E56D596B6912B243 (IdAtividade), PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE funcionario (departamento_id VARCHAR(10) NOT NULL, Id INT AUTO_INCREMENT NOT NULL, Nome VARCHAR(255) NOT NULL, INDEX IDX_7510A3CF5A91C08D (departamento_id), PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ocorrencia (Id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', Descricao VARCHAR(255) NOT NULL, Positivo TINYINT(1) NOT NULL, Sugestao VARCHAR(255) DEFAULT NULL, IdSprint VARCHAR(10) NOT NULL, IdAtividade CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_DC6ED96175E79F7B (IdSprint), INDEX IDX_DC6ED9616912B243 (IdAtividade), PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sprint (Id VARCHAR(10) NOT NULL, DataInicioSprint DATETIME NOT NULL, DataFimSprint DATETIME NOT NULL, DataImportacao DATETIME DEFAULT NULL, PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atividade ADD CONSTRAINT FK_136416C2AEA802F6 FOREIGN KEY (IdAplicacao) REFERENCES aplicacao (Id)');
        $this->addSql('ALTER TABLE atividade ADD CONSTRAINT FK_136416C275E79F7B FOREIGN KEY (IdSprint) REFERENCES sprint (Id)');
        $this->addSql('ALTER TABLE atividade ADD CONSTRAINT FK_136416C2F41106DD FOREIGN KEY (IdCategoriaAtividade) REFERENCES categoria_atividade (Id)');
        $this->addSql('ALTER TABLE entrega ADD CONSTRAINT FK_E56D596B6912B243 FOREIGN KEY (IdAtividade) REFERENCES atividade (Id)');
        $this->addSql('ALTER TABLE funcionario ADD CONSTRAINT FK_7510A3CF5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (Id)');
        $this->addSql('ALTER TABLE ocorrencia ADD CONSTRAINT FK_DC6ED96175E79F7B FOREIGN KEY (IdSprint) REFERENCES sprint (Id)');
        $this->addSql('ALTER TABLE ocorrencia ADD CONSTRAINT FK_DC6ED9616912B243 FOREIGN KEY (IdAtividade) REFERENCES atividade (Id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE atividade DROP FOREIGN KEY FK_136416C2AEA802F6');
        $this->addSql('ALTER TABLE entrega DROP FOREIGN KEY FK_E56D596B6912B243');
        $this->addSql('ALTER TABLE ocorrencia DROP FOREIGN KEY FK_DC6ED9616912B243');
        $this->addSql('ALTER TABLE atividade DROP FOREIGN KEY FK_136416C2F41106DD');
        $this->addSql('ALTER TABLE funcionario DROP FOREIGN KEY FK_7510A3CF5A91C08D');
        $this->addSql('ALTER TABLE atividade DROP FOREIGN KEY FK_136416C275E79F7B');
        $this->addSql('ALTER TABLE ocorrencia DROP FOREIGN KEY FK_DC6ED96175E79F7B');
        $this->addSql('DROP TABLE aplicacao');
        $this->addSql('DROP TABLE atividade');
        $this->addSql('DROP TABLE categoria_atividade');
        $this->addSql('DROP TABLE departamento');
        $this->addSql('DROP TABLE entrega');
        $this->addSql('DROP TABLE funcionario');
        $this->addSql('DROP TABLE ocorrencia');
        $this->addSql('DROP TABLE sprint');
    }
}

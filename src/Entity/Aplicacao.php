<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AplicacaoRepository")
 */
class Aplicacao implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="Id")
     */
    private $Id;

    /**
     * @ORM\Column(type="string", length=255, name="Nome")
     */
    private $Nome;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="Descricao")
     */
    private $Descricao;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="PublicoAlvo")
     */
    private $PublicoAlvo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="URLAcesso")
     */
    private $URLAcesso;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="URLAjuda")
     */
    private $URLAjuda;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="DataHomologacao")
     */
    private $DataHomologacao;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="AreaResponsavel")
     */
    private $AreaResponsavel;

    /**
     * @ORM\Column(type="string", length=100, nullable=true, name="UsuarioResponsavel")
     */
    private $UsuarioResponsavel;

    /**
     * @ORM\Column(type="boolean", name="Ativo")
     */
    private $Ativo;

    /**
     * @ORM\Column(type="boolean", name="Legado")
     */
    private $Legado;

    public function getId(): ?int
    {
        return $this->Id;
    }

    public function getNome(): ?string
    {
        return $this->Nome;
    }

    public function setNome(string $Nome): self
    {
        $this->Nome = $Nome;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->Descricao;
    }

    public function setDescricao(?string $Descricao): self
    {
        $this->Descricao = $Descricao;

        return $this;
    }

    public function getPublicoAlvo(): ?string
    {
        return $this->PublicoAlvo;
    }

    public function setPublicoAlvo(?string $PublicoAlvo): self
    {
        $this->PublicoAlvo = $PublicoAlvo;

        return $this;
    }

    public function getURLAcesso(): ?string
    {
        return $this->URLAcesso;
    }

    public function setURLAcesso(?string $URLAcesso): self
    {
        $this->URLAcesso = $URLAcesso;

        return $this;
    }

    public function getURLAjuda(): ?string
    {
        return $this->URLAjuda;
    }

    public function setURLAjuda(?string $URLAjuda): self
    {
        $this->URLAjuda = $URLAjuda;

        return $this;
    }

    public function getDataHomologacao(): ?\DateTimeInterface
    {
        return $this->DataHomologacao;
    }

    public function setDataHomologacao(?\DateTimeInterface $DataHomologacao): self
    {
        $this->DataHomologacao = $DataHomologacao;

        return $this;
    }

    public function getAreaResponsavel(): ?string
    {
        return $this->AreaResponsavel;
    }

    public function setAreaResponsavel(?string $AreaResponsavel): self
    {
        $this->AreaResponsavel = $AreaResponsavel;

        return $this;
    }

    public function getUsuarioResponsavel(): ?string
    {
        return $this->UsuarioResponsavel;
    }

    public function setUsuarioResponsavel(?string $UsuarioResponsavel): self
    {
        $this->UsuarioResponsavel = $UsuarioResponsavel;

        return $this;
    }

    public function getAtivo(): ?bool
    {
        return $this->Ativo;
    }

    public function setAtivo(bool $Ativo): self
    {
        $this->Ativo = $Ativo;

        return $this;
    }

    public function getLegado(): ?bool
    {
        return $this->Legado;
    }

    public function setLegado(bool $Legado): self
    {
        $this->Legado = $Legado;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'Id' =>$this->getId(),
            'Nome' =>$this->getNome(),
            'Descricao' =>$this->getDescricao(),
            'PublicoAlvo' =>$this->getPublicoAlvo(),
            'URLAcesso' =>$this->getURLAcesso(),
            'URLAjuda' =>$this->getURLAjuda(),
            'DataHomologacao' =>$this->getDataHomologacao(),
            'AreaResponsavel' =>$this->getAreaResponsavel(),
            'UsuarioResponsavel' =>$this->getUsuarioResponsavel(),
            'Ativo' =>$this->getAtivo(),
            'Legado' =>$this->getLegado()
        ];
    }     
}

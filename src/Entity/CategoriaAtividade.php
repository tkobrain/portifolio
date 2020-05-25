<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriaAtividadeRepository")
 */
class CategoriaAtividade implements \JsonSerializable
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
     * @ORM\Column(type="boolean", name="Ativo")
     */
    private $Ativo;

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

    public function getAtivo(): ?bool
    {
        return $this->Ativo;
    }

    public function setAtivo(bool $Ativo): self
    {
        $this->Ativo = $Ativo;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'Id' =>$this->getId(),
            'Nome' =>$this->getNome(),
            'Descricao' =>$this->getDescricao(),
            'Ativo' =>$this->getAtivo()
        ];
    }    
}

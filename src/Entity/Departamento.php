<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartamentoRepository")
 */
class Departamento implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=10, name="Id")
     */
    private $Id;

    /**
     * @ORM\Column(type="string", length=100, name="Descricao")
     */
    private $Descricao;

    /**
     * @ORM\Column(type="string", length=100, name="Responsavel")
     */
    private $Responsavel;

    /**
     * @ORM\Column(type="boolean", name="Ativo")
     */
    private $Ativo;

    public function getId(): ?string
    {
        return $this->Id;
    }

    public function setId(string $Id): self
    {
        $this->Id = $Id;

        return $this;
    }    

    public function getDescricao(): ?string
    {
        return $this->Descricao;
    }

    public function setDescricao(string $Descricao): self
    {
        $this->Descricao = $Descricao;

        return $this;
    }

    public function getResponsavel(): ?string
    {
        return $this->Responsavel;
    }

    public function setResponsavel(string $Responsavel): self
    {
        $this->Responsavel = $Responsavel;

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
            'Descricao' =>$this->getDescricao(),
            'Responsavel' =>$this->getResponsavel(),
            'Ativo' =>$this->getAtivo()
        ];
    }

}

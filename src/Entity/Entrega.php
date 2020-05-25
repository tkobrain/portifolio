<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
/**
 * @ORM\Entity(repositoryClass="App\Repository\EntregaRepository")
 */
class Entrega
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true, name="Id")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */          
    private $Id;

    /**
     * @ORM\Column(type="string", length=255, name="Descricao")
     */
    private $Descricao;

    /**
     * @ORM\Column(type="string", length=100, nullable=true, name="Solicitante")
     */
    private $Solicitante;

    /**
     * @ORM\Column(type="boolean", nullable=true, name="Aprovado")
     */
    private $Aprovado;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Atividade")
     * @ORM\JoinColumn(nullable=true, name="IdAtividade", referencedColumnName="Id")
     */
    private $Atividade;

    public function getId()
    {
        return $this->Id;
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

    public function getSolicitante(): ?string
    {
        return $this->Solicitante;
    }

    public function setSolicitante(?string $Solicitante): self
    {
        $this->Solicitante = $Solicitante;

        return $this;
    }

    public function getAprovado(): ?bool
    {
        return $this->Aprovado;
    }

    public function setAprovado(?bool $Aprovado): self
    {
        $this->Aprovado = $Aprovado;

        return $this;
    }

    public function getAtividade(): ?Atividade
    {
        return $this->Atividade;
    }

    public function setAtividade(?Atividade $Atividade): self
    {
        $this->Atividade = $Atividade;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'Id' =>$this->getId(),
            'Descricao' =>$this->getDescricao(),
            'Solicitante' =>$this->getSolicitante(),
            'Aprovado' =>$this->getAprovado(),            
            'IdAtividade' =>$this->getAtividade()->getId()
        ];

    }      
}

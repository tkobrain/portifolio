<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FuncionarioRepository")
 */
class Funcionario implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="Id")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="Nome")
     */
    private $Nome;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departamento", inversedBy="Funcionarios")
     * @ORM\JoinColumn(nullable=false, name="departamento_id", referencedColumnName="Id")
     */
    private $Departamento;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDepartamento(): ?Departamento
    {
        return $this->Departamento;
    }

    public function setDepartamento(?Departamento $Departamento): self
    {
        $this->Departamento = $Departamento;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'Id' => $this->getId(),
            'Nome' => $this->getNome(),
            'departamentoId' => $this->getDepartamento()->getId()
        ];
    }

}

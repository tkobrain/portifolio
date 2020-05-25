<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OcorrenciaRepository")
 */
class Ocorrencia  implements \JsonSerializable
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
     * @ORM\Column(type="boolean", name="Positivo")
     */     
    private $Positivo;
    /**
     * @ORM\Column(type="string", length=255, name="Sugestao", nullable=true)
     */         
    private $Sugestao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sprint", inversedBy="Ocorrencia")
     * @ORM\JoinColumn(nullable=false, name="IdSprint", referencedColumnName="Id")
     */
    private $Sprint;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Atividade", inversedBy="Ocorrencia")
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

    public function getPositivo(): ?bool
    {
        return $this->Positivo;
    }

    public function setPositivo(bool $Positivo): self
    {
        $this->Positivo = $Positivo;

        return $this;
    }

    public function getSugestao(): ?string
    {
        return $this->Sugestao;
    }

    public function setSugestao(?string $Sugestao): self
    {
        $this->Sugestao = $Sugestao;

        return $this;
    }

    public function getSprint(): ?Sprint
    {
        return $this->Sprint;
    }
    
    public function setSprint(?Sprint $Sprint): self
    {
        $this->Sprint = $Sprint;

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
            'Positivo' =>$this->getPositivo(),
            'Sugestao' =>$this->getSugestao(),            
            'IdSprint' =>$this->getSprint()->getId(),                        
            'IdAtividade' => null, //$this->getAtividade()->getId()
            '_link' => [
                [
                    'rel' => 'self',
                    'path' => '/ocorrencias/' . $this->getId()
                ],
                [
                    'rel' => 'sprint',
                    'path' => '/sprints/' . $this->getSprint()->getId()
                ]
            ]
        ];

    }      
}
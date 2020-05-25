<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;  
/**
 * @ORM\Entity(repositoryClass="App\Repository\AtividadeRepository")
 */
class Atividade  implements \JsonSerializable
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
     * @ORM\Column(type="float", name="Pontos")
     */
    private $Pontos;

    /**
     * @ORM\Column(type="time", nullable=true, name="Tempo")
     */
    private $Tempo;

    /**
     * @ORM\Column(type="boolean", name="Planejado")
     */
    private $Planejado;

    /**
     * @ORM\Column(type="integer", nullable=true, name="NumeroChamado")
     */
    private $NumeroChamado;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="DataChamado")
     */
    private $DataChamado;

    /**
     * @ORM\Column(type="string", length=60, nullable=true, name="Solicitante")
     */
    private $Solicitante;

    /**
     * @ORM\Column(type="string", length=60, nullable=true, name="RealizadoPor")
     */
    private $RealizadoPor;

    /**
     * @ORM\Column(type="boolean", nullable=true, name="Entrega")
     */
    private $Entrega;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Aplicacao")
     * @ORM\JoinColumn(nullable=false, name="IdAplicacao", referencedColumnName="Id")
     */
    private $Aplicacao; 

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sprint")
     * @ORM\JoinColumn(nullable=false, name="IdSprint", referencedColumnName="Id")
     */
    private $Sprint;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoriaAtividade")
     * @ORM\JoinColumn(nullable=false, name="IdCategoriaAtividade", referencedColumnName="Id")
     */
    private $CategoriaAtividade;   

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

    public function getPontos(): ?float
    {
        return $this->Pontos;
    }

    public function setPontos(float $Pontos): self
    {
        $this->Pontos = $Pontos;

        return $this;
    }

    public function getTempo(): ?\DateTimeInterface
    {
        return $this->Tempo;
    }

    public function setTempo(?\DateTimeInterface $Tempo): self
    {
        $this->Tempo = $Tempo;

        return $this;
    }    

    public function getPlanejado(): ?bool
    {
        return $this->Planejado;
    }

    public function setPlanejado(bool $Planejado): self
    {
        $this->Planejado = $Planejado;

        return $this;
    }

    public function getNumeroChamado(): ?int
    {
        return $this->NumeroChamado;
    }

    public function setNumeroChamado(?int $NumeroChamado): self
    {
        $this->NumeroChamado = $NumeroChamado;

        return $this;
    }

    public function getDataChamado(): ?\DateTimeInterface
    {
        return $this->DataChamado;
    }

    public function setDataChamado(?\DateTimeInterface $DataChamado): self
    {
        $this->DataChamado = $DataChamado;

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

    public function getRealizadoPor(): ?string
    {
        return $this->RealizadoPor;
    }

    public function setRealizadoPor(?string $RealizadoPor): self
    {
        $this->RealizadoPor = $RealizadoPor;

        return $this;
    }

    public function getEntrega(): ?bool
    {
        return $this->Entrega;
    }

    public function setEntrega(?bool $Entrega): self
    {
        $this->Entrega = $Entrega;

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

    public function getAplicacao(): ?Aplicacao
    {
        return $this->Aplicacao;
    }

    public function setAplicacao(?Aplicacao $Aplicacao): self
    {
        $this->Aplicacao = $Aplicacao;

        return $this;
    }

    public function getCategoriaAtividade(): ?CategoriaAtividade
    {
        return $this->categoriaAtividade;
    }

    public function setCategoriaAtividade(?CategoriaAtividade $categoriaAtividade): self
    {
        $this->categoriaAtividade = $categoriaAtividade;

        return $this;
    }    

    public function jsonSerialize()
    {
        return [
            'Id' =>$this->getId(),
            'IdAplicacao' =>$this->getAplicacao()->getId(),
            'Descricao' =>$this->getDescricao(),
            'Pontos' =>$this->getPontos(),
            'Tempo' =>$this->getTempo(),
            'IdSprint' =>$this->getSprint()->getId(),
            'Planejado' =>$this->getPlanejado(),
            'IdCategoriaAtividade' =>$this->getCategoriaAtividade()->getId(),            
            'NumeroChamado' =>$this->getNumeroChamado(),
            'DataChamado' =>$this->getDataChamado(),            
            'Solicitante' =>$this->getSolicitante(),                        
            'RealizadoPor' =>$this->getRealizadoPor(),                                    
            'Entrega' =>$this->getEntrega()
        ];
    }     
}

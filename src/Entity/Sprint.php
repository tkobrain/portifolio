<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SprintRepository")
 */
class Sprint implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=10, name="Id")
     */
    private $Id;					
    /**
     * @ORM\Column(type="datetime", name="DataInicioSprint")
     */    
    private $DataInicioSprint;
    /**
     * @ORM\Column(type="datetime", name="DataFimSprint")
     */    
    private $DataFimSprint;	
    /**
     * @ORM\Column(type="datetime", name="DataImportacao", nullable=TRUE)
     */    
    private $DataImportacao;		


    public function getId(): ?string
    {
        return $this->Id;
    }

    public function setId(string $Id): self
    {
        $this->Id = $Id;

        return $this;
    }

    public function getDataInicioSprint(): DateTime
    {
        return $this->DataInicioSprint;
    }

    public function setDataInicioSprint(DateTime $DataInicioSprint): self
    {
        $this->DataInicioSprint = $DataInicioSprint;

        return $this;
    }

    public function getDataFimSprint(): DateTime
    {
        return $this->DataFimSprint;
    }

    public function setDataFimSprint(DateTime $DataFimSprint): self
    {
        $this->DataFimSprint = $DataFimSprint;

        return $this;
    }

    public function getDataImportacao(): ?DateTime
    {
        return $this->DataImportacao;
    }

    public function setDataImportacao(?DateTime $DataImportacao): self
    {
        $this->DataImportacao = $DataImportacao;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'Id' =>$this->getId(),
            'DataInicioSprint' =>$this->getDataInicioSprint(),
            'DataFimSprint' =>$this->getDataFimSprint(),
            'DataImportacao' =>$this->getDataImportacao(),
            '_link' => [
                [
                    'rel' => 'self',
                    'path' => '/sprints/' . $this->getId()
                ]
                ],
            [
                'rel' => 'ocorrencias',
                'path' => '/sprints/' . $this->getId(). '/ocorrencias'
            ]                        
        ];
    }
}
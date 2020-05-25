<?php

namespace App\Helper;

use App\Entity\Ocorrencia;
use App\Repository\SprintRepository;
use App\Repository\AtividadeRepository;

class OcorrenciaFactory implements EntityFactoryInterface
{
    /**
     * @var SprintRepository
     */
    private $sprintRepository;

    /**
     *  @var AtividadeRepository
     */
    private $atividadeRepository;

    public function __construct(
        SprintRepository $sprintRepository,
        AtividadeRepository $atividadeRepository
        )
    {
        $this->sprintRepository = $sprintRepository;
        $this->atividadeRepository = $atividadeRepository;        
    }

    public function createEntity(string $json): Ocorrencia
    {
        $dadosEmJson = json_decode($json);
        
        $this->checkAllProperties($dadosEmJson);

        $Sprint = $this->sprintRepository->find($dadosEmJson->IdSprint);

        $atividade = (!empty($dadosEmJson->IdAtividade))?$this->atividadeRepository->find($dadosEmJson->IdAtividade):null;        

        $ocorrencia = new Ocorrencia();
        $ocorrencia
            ->setDescricao($dadosEmJson->Descricao)
            ->setPositivo($dadosEmJson->Positivo)
            ->setSugestao($dadosEmJson->Sugestao)
            ->setSprint($Sprint)            
            ->setAtividade($atividade);

        return $ocorrencia;
    }

    private function checkAllProperties(object $objetoJson): void
    {
        if (!property_exists($objetoJson, 'Descricao')) {
            throw new EntityFactoryException('Ocorrência precisa de uma descrição');
        }

        if (!property_exists($objetoJson, 'Positivo')) {
            throw new EntityFactoryException('Ocorrência precisa status');
        }
        
        if (!property_exists($objetoJson, 'Sugestao')) {
            throw new EntityFactoryException('Ocorrência precisa de uma sugestão');
        }

        if (!property_exists($objetoJson, 'IdSprint')) {
            throw new EntityFactoryException('Ocorrência precisa de uma sprint');
        }          
    }        
}
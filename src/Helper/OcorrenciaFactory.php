<?php

namespace App\Helper;

use App\Entity\Ocorrencia;
use App\Repository\SprintRepository;
use App\Repository\AtividadeRepository;

class OcorrenciaFactory implements EntidadeFactoryInterface
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

    public function criarEntidade(string $json): Ocorrencia
    {
        $dadosEmJson = json_decode($json);
        $Sprint = $this->sprintRepository->find($dadosEmJson->IdSprint);

        $atividade = (!empty($dadosEmJson->IdAtividade))?$this->atividadeRepository->find($dadosEmJson->IdAtividade):null;        

        $ocorrencia = new Ocorrencia();
        $ocorrencia
            //->setId($Id)        
            ->setDescricao($dadosEmJson->Descricao)
            ->setPositivo($dadosEmJson->Positivo)
            ->setSugestao($dadosEmJson->Sugestao)
            ->setSprint($Sprint)            
            ->setAtividade($atividade);

        return $ocorrencia;
    }
}
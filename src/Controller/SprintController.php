<?php

namespace App\Controller;

use App\Entity\Sprint;
use App\Helper\SprintFactory;
use App\Controller\BaseController;
use App\Helper\ExtratorDadosRequest;
use App\Repository\SprintRepository;

class SprintController extends BaseController
{
    public function __construct(
        SprintFactory $sprintFactory,        
        ExtratorDadosRequest $extratorDadosRequest,
        SprintRepository $sprintRepository
    )
    {
        parent::__construct($sprintFactory, $extratorDadosRequest, $sprintRepository);
        $this->sprintFactory = $sprintFactory;
    }

    public function atualizaEntidadeExistente($id, $entidade)
    {
        /** @var Sprint $entidadeExistente */
        $entidadeExistente = $this->getDoctrine()->getRepository(Sprint::class)->find($id);
        if (is_null($entidadeExistente)) {
            throw new \InvalidArgumentException();
        }
        $entidadeExistente        
            ->setDataInicioSprint($entidade->getDataInicioSprint())
            ->setDataFimSprint($entidade->getDataFimSprint())
            ->setDataImportacao($entidade->getDataImportacao());

        return $entidadeExistente;
    }    

}
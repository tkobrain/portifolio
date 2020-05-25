<?php

namespace App\Controller;

use App\Helper\OcorrenciaFactory;
use App\Controller\BaseController;
use App\Helper\ExtratorDadosRequest;
use App\Repository\OcorrenciaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class OcorrenciaController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        OcorrenciaFactory $ocorrenciaFactory,
        OcorrenciaRepository $ocorrenciaRepository,
        ExtratorDadosRequest $extratorDadosRequest        
    )
    {
        parent::__construct($entityManager, $ocorrenciaRepository, $ocorrenciaFactory, $extratorDadosRequest);
        $this->ocorrenciaFactory = $ocorrenciaFactory;   
        $this->ocorrenciaRepository = $ocorrenciaRepository;             
    }

    
    /**
     * @Route("/sprints/{IdSprint}/ocorrencias", methods={"GET"})
     */
    public function buscaPorSrint(string $IdSprint): Response
    {
        $ocorrencias = $this->ocorrenciaRepository->findBy([
            'Sprint' => $IdSprint
        ]);

        return new JsonResponse($ocorrencias);
    }    

    public function atualizaEntidadeExistente($id, $entidade)
    {
        /** @var Sprint $entidadeExistente */
        $entidadeExistente = $this->repository->find($id);
        if (is_null($entidadeExistente)) {
            throw new \InvalidArgumentException();
        }
        $entidadeExistente        
            ->setDescricao($entidade->getDescricao())
            ->setPositivo($entidade->getPositivo())
            ->setSugestao($entidade->getSugestao())
            ->setSprint($entidade->getSprint())            
            ->setAtividade($entidade->getAtividade());

        return $entidadeExistente;
    }      
}

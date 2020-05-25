<?php

namespace App\Controller;

use App\Entity\Sprint;
use App\Helper\SprintFactory;
use Doctrine\ORM\EntityManager;
use App\Controller\BaseController;
use App\Helper\ExtratorDadosRequest;
use App\Repository\SprintRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SprintController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        SprintFactory $sprintFactory,
        SprintRepository $sprintRepository,
        ExtratorDadosRequest $extratorDadosRequest                
    )
    {
        parent::__construct($entityManager, $sprintRepository, $sprintFactory, $extratorDadosRequest);        
        $this->entityManager = $entityManager;
        $this->sprintFactory = $sprintFactory;
    }

    public function atualizaEntidadeExistente($id, $entidade)
    {
        /** @var Sprint $entidadeExistente */
        $entidadeExistente = $this->repository->find($id);
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
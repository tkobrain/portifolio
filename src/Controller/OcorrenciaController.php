<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Helper\OcorrenciaFactory;
use App\Controller\BaseController;
use App\Entity\HypermidiaResponse;
use App\Helper\ExtratorDadosRequest;
use Psr\Cache\CacheItemPoolInterface;
use App\Repository\OcorrenciaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class OcorrenciaController extends BaseController
{
    public function __construct(
        OcorrenciaFactory $ocorrenciaFactory,
        ExtratorDadosRequest $extratorDadosRequest,
        OcorrenciaRepository $ocorrenciaRepository,
        CacheItemPoolInterface $cache,
        LoggerInterface $logger
    )
    {
        parent::__construct($ocorrenciaFactory, $extratorDadosRequest, $ocorrenciaRepository,$cache, $logger);
        $this->ocorrenciaFactory = $ocorrenciaFactory;   
    }

    
    /**
     * @Route("/sprints/{IdSprint}/ocorrencias", methods={"GET"})
     */
    public function buscaPorSrint(string $IdSprint, Request $request): Response
    {
        $filterData = ['Sprint' => $IdSprint] + $this->extratorDadosRequest->buscaDadosFiltro($request);
        $orderData = $this->extratorDadosRequest->buscaDadosOrdenacao($request);
        $paginationData = $this->extratorDadosRequest->buscaDadosPaginacao($request);
        $itemsPerPage = $_ENV['ITEMS_PER_PAGE'] ?? 10;

        $ocorrencias = $this->repository->findBy($filterData, $orderData, $itemsPerPage, ($paginationData - 1) * 10);

        $hypermidiaResponse = new HypermidiaResponse($ocorrencias, true, Response::HTTP_OK, $paginationData, $itemsPerPage);
        return $hypermidiaResponse->getResponse();
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
    
    public function cachePrefix(): string
    {
        return 'sprint_';
    }    
}

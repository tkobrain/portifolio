<?php

namespace App\Controller;

use App\Helper\ResponseFactory;
use App\Entity\HypermidiaResponse;
use App\Helper\ExtratorDadosRequest;
use App\Helper\EntityFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController  extends AbstractController
{
    /**
     * @var ObjectRepository
     */
    protected $repository;
    /**
     * @var EntityFactoryInterface
     */
    protected $entityFactory;
    /**
     * @var ExtratorDadosRequest
     */
    protected $extratorDadosRequest;

    public function __construct(
        EntityFactoryInterface $entityFactory,         
        ExtratorDadosRequest $extratorDadosRequest,
        ObjectRepository $repository
    ) {
        $this->entityFactory = $entityFactory;
        $this->extratorDadosRequest = $extratorDadosRequest;                
        $this->repository = $repository;
    }

    public function novo(Request $request): Response
    {
        $entity = $this->entityFactory->createEntity($request->getContent());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();

        return $this->json($entity, Response::HTTP_CREATED);
    }

    public function buscarTodos(Request $request)
    {
        try {        

            $filtro = $this->extratorDadosRequest->buscaDadosFiltro($request);
            $informacoesDeOrdenacao = $this->extratorDadosRequest->buscaDadosOrdenacao($request);
            [$paginaAtual, $itensPorPagina] = $this->extratorDadosRequest->buscaDadosPaginacao($request);

            $lista = $this->repository->findBy(
                $filtro,
                $informacoesDeOrdenacao,
                $itensPorPagina,
                ($paginaAtual - 1) * $itensPorPagina
            );
            /*
            $fabricaResposta = new ResponseFactory(
                true,
                $lista,
                Response::HTTP_OK,
                $paginaAtual,
                $itensPorPagina
            );       
            */
            $hypermidiaResponse = new HypermidiaResponse($lista, true, Response::HTTP_OK, $paginaAtual, $itensPorPagina);             
        }catch(\Throwable $erro)
        {
            $hypermidiaResponse = HypermidiaResponse::fromError($erro);
        }
        
        return $hypermidiaResponse->getResponse();
    }

    public function buscarUm($id): Response
    {
        $entidade = $this->repository->find($id);
        $hypermidiaResponse = new HypermidiaResponse($entidade, true, Response::HTTP_OK, null);

        /*
        $statusResposta = is_null($entidade)
            ? Response::HTTP_NO_CONTENT
            : Response::HTTP_OK;
        $fabricaResposta = new ResponseFactory(
            true,
            $entidade,
            $statusResposta
        );
        */ 
        
        return $hypermidiaResponse->getResponse();
    }

    public function remove($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entidade = $this->repository->find($id);
        $entityManager->remove($entidade);
        $entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
    
    public function atualiza($id, Request $request): Response
    {
        $entidade = $this->entityFactory->createEntity($request->getContent());
        $entidadeExistente = $this->atualizaEntidadeExistente($id, $entidade);        

        $this->getDoctrine()->getManager()->flush();

        return $this->json($entidadeExistente);
    }
    
    abstract function atualizaEntidadeExistente($id, $entidade);
}
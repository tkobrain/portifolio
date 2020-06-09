<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Helper\ResponseFactory;
use App\Entity\HypermidiaResponse;
use App\Helper\ExtratorDadosRequest;
use Psr\Cache\CacheItemPoolInterface;
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
        ObjectRepository $repository,
        CacheItemPoolInterface $cache,
        LoggerInterface $logger
    ) {
        $this->entityFactory = $entityFactory;
        $this->extratorDadosRequest = $extratorDadosRequest;                
        $this->repository = $repository;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    public function novo(Request $request): Response
    {
        $entity = $this->entityFactory->createEntity($request->getContent());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();

        $cacheItem = $this->cache->getItem(
            $this->cachePrefix().$entity->getId()
        );

        $cacheItem->set($entity);
        $this->cache->save($cacheItem);

        $this->logger
            ->notice('Novo registro de {entidade} adicionado, ID: {id}.',
            [
                'entidade' => get_class($entity),
                'id' => $entity->getId()
            ]
        );

        return $this->json($entity, Response::HTTP_CREATED);
    }

    public function buscarTodos(Request $request)
    {
        try {        

            $filterData = $this->extratorDadosRequest->buscaDadosFiltro($request);
            $orderData = $this->extratorDadosRequest->buscaDadosOrdenacao($request);
            $paginationData = $this->extratorDadosRequest->buscaDadosPaginacao($request);
            $itemsPerPage = $_ENV['ITEMS_PER_PAGE'] ?? 10;            
            //[$paginaAtual, $itensPorPagina] = $this->extratorDadosRequest->buscaDadosPaginacao($request);
            //$itemsPerPage = $_ENV['ITEMS_PER_PAGE'] ?? 10;            

            $lista = $this->repository->findBy(
                $filterData,
                $orderData,
                $itemsPerPage,
                ($paginationData - 1) * $itemsPerPage
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
            $hypermidiaResponse = new HypermidiaResponse($lista, true, Response::HTTP_OK, $paginationData, $itemsPerPage);             
        }catch(\Throwable $erro)
        {
            $hypermidiaResponse = HypermidiaResponse::fromError($erro);
        }
        
        return $hypermidiaResponse->getResponse();
    }

    public function buscarUm($id): Response
    {   
        //SUBSTITUIDO POR UTILIZACAO DE CACHE
        //$entidade = $this->repository->find($id);

        $entidade = $this->cache->hasItem($this->cachePrefix().$id) ? 
            $this->cache->getItem($this->cachePrefix().$id)->get() :
            $this->repository->find($id);        

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

        $this->cache->delete($this->cachePrefix().$id);

        return new Response('', Response::HTTP_NO_CONTENT);
    }
    
    public function atualiza($id, Request $request): Response
    {
        $entidade = $this->entityFactory->createEntity($request->getContent());
        $entidadeExistente = $this->atualizaEntidadeExistente($id, $entidade);        

        $this->getDoctrine()->getManager()->flush();

        $cacheItem = $this->cache->getItem($this->cachePrefix() . $id);
        $cacheItem->set($entidadeExistente);
        $this->cache->save($cacheItem);        

        return $this->json($entidadeExistente);
    }
    
    abstract function atualizaEntidadeExistente($id, $entidade);
    abstract function cachePrefix():string;
}
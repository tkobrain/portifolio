<?php

namespace App\Controller;

use App\Entity\CategoriaAtividade;
use Doctrine\ORM\EntityManagerInterface;
use App\Helper\CategoriaAtividadeFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoriaAtividadeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */    
    public function __construct(
        EntityManagerInterface $entityManager,
        CategoriaAtividadeFactory $categoriaAtividadeFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->categoriaAtividadeFactory = $categoriaAtividadeFactory;                
    }

    /**
     * @Route("/categoria", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $categoriaAtividade = $this->categoriaAtividadeFactory->criarCategoriaAtividade($corpoRequisicao);

        $dadosEmJson = json_decode($corpoRequisicao);
        
        $this-> entityManager->persist($categoriaAtividade);
        $this-> entityManager->flush();

        return new JsonResponse($categoriaAtividade);
    }

    /**
     * @Route("/categoria/{_Id}", methods= {"PUT"})
     */    
    public function atualiza(int $_Id, Request $request) : Response
    {
        $corpoRequisicao = $request->getContent();
        $categoriaAtividadeEnviada = $this->sprintFactory->criarCategoriaAtividade($corpoRequisicao);

        $categoriaAtividadeExistente = $this->buscaCategoriaAtividade($_Id);

        if(is_null($categoriaAtividadeExistente)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $categoriaAtividadeExistente
            ->setNome($categoriaAtividadeEnviada->getNome())
            ->setDescricao($categoriaAtividadeEnviada->getDescricao())
            ->setAtivo($categoriaAtividadeEnviada->getAtivo());

        $this-> entityManager->flush();

        return new JsonResponse($categoriaAtividadeExistente);
    } 

    /**
     * @Route("/categoria/{_Id}", methods= {"DELETE"})
     */
    public function remove(int $_Id): Response
    {
        $categoriaAtividade = $this->buscaCategoriaAtividade($_Id);
        $this->entityManager->remove($categoriaAtividade);
    
        $this->entityManager->flush();
    
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/categoria/{_Id}", methods= {"GET"})
     */  
    public function buscarUm(int $_Id, Request $request) : Response
    {
        $categoriaAtividadeExistente = $this->buscaCategoriaAtividade($_Id);

        $codigoRetorno = (is_null($categoriaAtividadeExistente))?Response::HTTP_NO_CONTENT:200;

        return new JsonResponse($categoriaAtividadeExistente,$codigoRetorno);
    }  

    /**
     * @Route("/categoria", methods= {"GET"})
     */  
    public function buscarTodos() : Response
    {
        $repositorioDeCategoriaAtividade = $this
        ->getDoctrine()
        ->getRepository(CategoriaAtividade::class);

        $categoriaAtividadeList = $repositorioDeCategoriaAtividade->findAll();

        return new JsonResponse($categoriaAtividadeList);
    }    

    public function buscaCategoriaAtividade(int $_Id)
    {
        $repositorioDeCategoriaAtividade = $this
            ->getDoctrine()
            ->getRepository(CategoriaAtividade::class);
        $categoriaAtividade = $repositorioDeCategoriaAtividade->find($_Id);

        return $categoriaAtividade; 
    }
}

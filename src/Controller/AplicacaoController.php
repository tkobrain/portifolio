<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use App\Entity\Aplicacao;
use Doctrine\ORM\EntityManagerInterface;
use App\Helper\AplicacaoFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AplicacaoController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */    
    public function __construct(
        EntityManagerInterface $entityManager,
        AplicacaoFactory $aplicacaoFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->aplicacaoFactory = $aplicacaoFactory;                
    }    

    /**
     * @Route("/atividade", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $aplicacao = $this->aplicacaoFactory->criarAplicacao($corpoRequisicao);

        $dadosEmJson = json_decode($corpoRequisicao);
        
        $this-> entityManager->persist($aplicacao);
        $this-> entityManager->flush();

        return new JsonResponse($aplicacao);
    }

    /**
     * @Route("/atividade/{_Id}", methods= {"PUT"})
     */    
    public function atualiza(int $_Id, Request $request) : Response
    {
        $corpoRequisicao = $request->getContent();
        $aplicacaoEnviada = $this->sprintFactory->criarAplicacao($corpoRequisicao);

        $aplicacaoExistente = $this->buscaAplicacao($_Id);

        if(is_null($aplicacaoExistente)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $aplicacaoExistente
            ->setNome($aplicacaoEnviada->getNome())
            ->setDescricao($aplicacaoEnviada->getDescricao())
            ->setAtivo($aplicacaoEnviada->getAtivo());

        $this-> entityManager->flush();

        return new JsonResponse($aplicacaoExistente);
    } 

    /**
     * @Route("/atividade/{_Id}", methods= {"DELETE"})
     */
    public function remove(int $_Id): Response
    {
        $aplicacao = $this->buscaAplicacao($_Id);
        $this->entityManager->remove($aplicacao);
    
        $this->entityManager->flush();
    
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/atividade/{_Id}", methods= {"GET"})
     */  
    public function buscarUm(int $_Id, Request $request) : Response
    {
        $aplicacaoExistente = $this->buscaAplicacao($_Id);

        $codigoRetorno = (is_null($aplicacaoExistente))?Response::HTTP_NO_CONTENT:200;

        return new JsonResponse($aplicacaoExistente,$codigoRetorno);
    }  

    /**
     * @Route("/atividade", methods= {"GET"})
     */  
    public function buscarTodos() : Response
    {
        $repositorioDeAplicacao = $this
        ->getDoctrine()
        ->getRepository(Aplicacao::class);

        $aplicacaoList = $repositorioDeAplicacao->findAll();

        return new JsonResponse($aplicacaoList);
    }    

    public function buscaAplicacao(int $_Id)
    {
        $repositorioDeAplicacao = $this
            ->getDoctrine()
            ->getRepository(Aplicacao::class);
        $aplicacao = $repositorioDeAplicacao->find($_Id);

        return $aplicacao; 
    }
}

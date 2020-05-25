<?php

namespace App\Controller;

use App\Entity\Departamento;
use App\Helper\DepartamentoFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class DepartamentoController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        DepartamentoFactory $departamentoFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->departamentoFactory = $departamentoFactory;        

    }

    /**
     * @Route("/departamento", methods= {"POST"})
     */    
    public function novo(Request $request) : Response
    {
        $corpoRequisicao = $request->getContent();
        $departamento = $this->departamentoFactory->criarDepartamento($corpoRequisicao);

        //$dadosEmJson = json_decode($corpoRequisicao);
       
        //var_dump($departamento);

        $this-> entityManager->persist($departamento);
        $this-> entityManager->flush();

        return new JsonResponse($departamento);
    }    

    /**
     * @Route("/departamento/{_Id}", methods= {"PUT"})
     */    
    public function atualiza(string $_Id, Request $request) : Response
    {
        //$Id = $request->get('Id');
        $corpoRequisicao = $request->getContent();
        $departamentoEnviada = $this->departamentoFactory->atualizarDepartamento($corpoRequisicao);

        $departamentoExistente = $this->buscaDepartamento($_Id);

        if(is_null($departamentoExistente)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $departamentoExistente
            ->setDescricao($departamentoEnviada->getDescricao())
            ->setResponsavel($departamentoEnviada->getResponsavel())
            ->setAtivo($departamentoEnviada->getAtivo());

        $this-> entityManager->flush();

        return new JsonResponse($departamentoExistente);
    }

    /**
     * @Route("/departamento", methods= {"GET"})
     */  
    public function buscarTodos() : Response
    {
        $repositorioDeDepartamentos = $this
        ->getDoctrine()
        ->getRepository(Departamento::class);

        $departamentoList = $repositorioDeDepartamentos->findAll();

        return new JsonResponse($departamentoList);
    }

    /**
     * @Route("/departamento/{_Id}", methods= {"GET"})
     */  
    public function buscarUm(Request $request) : Response
    {
        $_Id = $request->get('_Id');

        $departamentoExistente = $this->buscaDepartamento($_Id);

        $codigoRetorno = (is_null($departamentoExistente))?Response::HTTP_NO_CONTENT:200;

        return new JsonResponse($departamentoExistente,$codigoRetorno);
    }

    /**
     * @Route("/departamento/{_Id}", methods= {"DELETE"})
     */
    public function remove(string $_Id): Response
    {
        $departamento = $this->buscaDepartamento($_Id);
        $this->entityManager->remove($departamento);
    
        $this->entityManager->flush();
    
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param string $id
     * @return object|null
     */    
    public function buscaDepartamento(string $_Id)
    {
        $repositorioDeDepartamentos = $this
        ->getDoctrine()
        ->getRepository(Departamento::class);
        $departamento = $repositorioDeDepartamentos->find($_Id);

        return $departamento; 
    }
}

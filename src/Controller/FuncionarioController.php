<?php

namespace App\Controller;

use App\Entity\Funcionario;
use App\Helper\FuncionarioFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FuncionarioController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var FuncionarioFactory
     */
    private $funcionarioFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        FuncionarioFactory $funcionarioFactory
    ) {
        $this->entityManager = $entityManager;
        $this->funcionarioFactory = $funcionarioFactory;
    }

    /**
     * @Route("/funcionario", methods={"POST"})
     */
    public function novo(Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $funcionario = $this->funcionarioFactory->criarFuncionario($corpoRequisicao);

        $this->entityManager->persist($funcionario);
        $this->entityManager->flush();

        return new JsonResponse($funcionario);
    }

    /**
     * @Route("/funcionario", methods={"GET"})
     */
    public function buscarTodos(): Response
    {
        $repositorioDeFuncionarios = $this
            ->getDoctrine()
            ->getRepository(Funcionario::class);

        $funcionarioList = $repositorioDeFuncionarios->findAll();

        return new JsonResponse($funcionarioList);
    }

    /**
     * @Route("/funcionario/{id}", methods={"GET"})
     */
    public function buscarUm(int $id): Response
    {
        $funcionario = $this->buscaFuncionario($id);
        $codigoRetorno = is_null($funcionario) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($funcionario, $codigoRetorno);
    }

    /**
     * @Route("/funcionario/{id}", methods={"PUT"})
     */
    public function atualiza(int $id, Request $request): Response
    {
        $corpoRequisicao = $request->getContent();
        $funcionarioEnviado = $this->funcionarioFactory->criarFuncionario($corpoRequisicao);

        $funcionarioExistente = $this->buscaFuncionario($id);
        if (is_null($funcionarioExistente)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $funcionarioExistente
            ->setNome($funcionarioEnviado->getNome());

        $this->entityManager->flush();

        return new JsonResponse($funcionarioExistente);
    }

    /**
     * @Route("/funcionario/{id}", methods={"DELETE"})
     */
    public function remove(int $id): Response
    {
        $funcionario = $this->buscaFuncionario($id);
        $this->entityManager->remove($funcionario);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function buscaFuncionario(int $id)
    {
        $repositorioDeFuncionarios = $this
            ->getDoctrine()
            ->getRepository(Funcionario::class);
        $funcionario = $repositorioDeFuncionarios->find($id);

        return $funcionario;
    }
}

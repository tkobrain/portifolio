<?php

namespace App\Helper;

use App\Entity\Funcionario;
use App\Repository\DepartamentoRepository;

class FuncionarioFactory
{
    /**
     * @var DepartamentoRepository
     */
    private $departamentoRepository;

    public function __construct(DepartamentoRepository $departamentoRepository)
    {
        $this->departamentoRepository = $departamentoRepository;
    }

    public function criarFuncionario(string $json) : Funcionario
    {
        $dadosEmJson = json_decode($json);
        $IdDepartamento = $dadosEmJson->IdDepartamento;
        $departamento = $this->departamentoRepository->find($IdDepartamento);

        //var_dump($departamento);

        $funcionario = new Funcionario();

        $funcionario
            ->setNome($dadosEmJson->Nome)
            ->setDepartamento($departamento);            
        return $funcionario;
    }

}
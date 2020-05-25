<?php

namespace App\Helper;

use App\Entity\Funcionario;
use App\Repository\DepartamentoRepository;

class FuncionarioFactory  implements EntityFactoryInterface
{
    /**
     * @var DepartamentoRepository
     */
    private $departamentoRepository;

    public function __construct(DepartamentoRepository $departamentoRepository)
    {
        $this->departamentoRepository = $departamentoRepository;
    }

    public function createEntity(string $json) : Funcionario
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
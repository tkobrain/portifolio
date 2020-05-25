<?php

namespace App\Helper;

use App\Entity\Departamento;

class DepartamentoFactory
{
    public function criarDepartamento(string $json) : Departamento
    {
        $dadosEmJson = json_decode($json);

        $departamento = new Departamento();

        //var_dump($dadosEmJson);

        $departamento
            ->setId($dadosEmJson->Id)        
            ->setDescricao($dadosEmJson->Descricao)
            ->setResponsavel($dadosEmJson->Responsavel)
            ->setAtivo($dadosEmJson->Ativo);

        return $departamento;
    }


    public function atualizarDepartamento(string $json) : Departamento
    {
        $dadosEmJson = json_decode($json);

        $departamento = new Departamento();

        $departamento
            ->setDescricao($dadosEmJson->Descricao)
            ->setResponsavel($dadosEmJson->Responsavel)
            ->setAtivo($dadosEmJson->Ativo);

        return $departamento;

    }    

}
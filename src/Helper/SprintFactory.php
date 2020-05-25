<?php

namespace App\Helper;

use App\Entity\Sprint;

class SprintFactory implements EntidadeFactoryInterface
{

    public function criarEntidade(string $json): Sprint
    {
        $dadosEmJson = json_decode($json);
        $sprint = new Sprint();

        $dataInicio = new \DateTime($dadosEmJson->DataInicioSprint);
        $dataFim = new \DateTime($dadosEmJson->DataFimSprint);
        $dataImportacao = (!empty($dadosEmJson->DataImportacao))?new \DateTime($dadosEmJson->DataImportacao):null;
        

        //Melhorar
        If(isset($dadosEmJson->Id))
        {
            $sprint      
                ->setId($dadosEmJson->Id)                                
                ->setDataInicioSprint($dataInicio)
                ->setDataFimSprint($dataFim)
                ->setDataImportacao($dataImportacao);            
        }else{
            $sprint
                ->setDataInicioSprint($dataInicio)
                ->setDataFimSprint($dataFim)
                ->setDataImportacao($dataImportacao);                        
        }

        return $sprint;
    }

    public function atualizarSprint(string $json) : Sprint
    {
        $dadosEmJson = json_decode($json);

        $sprint = new Sprint();

        $dataInicio = new \DateTime($dadosEmJson->DataInicioSprint);
        $dataFim = new \DateTime($dadosEmJson->DataFimSprint);
        $dataImportacao = (!empty($dadosEmJson->DataImportacao))?new \DateTime($dadosEmJson->DataImportacao):null;

        $sprint
            ->setDataInicioSprint($dataInicio)
            ->setDataFimSprint($dataFim)
            ->setDataImportacao($dataImportacao);

        return $sprint;

    }    

}
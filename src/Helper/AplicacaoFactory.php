<?php

namespace App\Helper;

use App\Entity\Aplicacao;

class AplicacaoFactory
{
    public function criarAplicacao(string $json) : Aplicacao
    {
        $dadosEmJson = json_decode($json);

        $aplicacao = new Aplicacao();

        $dataHomologacao = new \DateTime($dadosEmJson->DataHomologacao);

        $aplicacao
            ->setDescricao($dadosEmJson->Descricao)    
            ->setNome($dadosEmJson->Nome)            
            ->setPublicoAlvo($dadosEmJson->PublicoAlvo)
            ->setURLAcesso($dadosEmJson->URLAcesso)
            ->setURLAjuda($dadosEmJson->URLAjuda)
            ->setDataHomologacao($dataHomologacao)
            ->setAreaResponsavel($dadosEmJson->AreaResponsavel)
            ->setUsuarioResponsavel($dadosEmJson->UsuarioResponsavel)
            ->setAtivo($dadosEmJson->Ativo)
            ->setLegado($dadosEmJson->Legado);

        return $aplicacao;        
    }
}
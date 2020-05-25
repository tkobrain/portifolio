<?php

namespace App\Helper;

use App\Entity\CategoriaAtividade;

class CategoriaAtividadeFactory
{
    public function criarCategoriaAtividade(string $json) : CategoriaAtividade
    {
        $dadosEmJson = json_decode($json);

        $categoriaAtividade = new CategoriaAtividade();

        $categoriaAtividade
            ->setNome($dadosEmJson->Nome)
            ->setDescricao($dadosEmJson->Descricao)
            ->setAtivo($dadosEmJson->Ativo);

        return $categoriaAtividade;
    }
}
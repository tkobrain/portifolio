<?php

namespace App\Helper;

use App\Entity\CategoriaAtividade;

class CategoriaAtividadeFactory  implements EntityFactoryInterface
{
    public function createEntity(string $json) : CategoriaAtividade
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
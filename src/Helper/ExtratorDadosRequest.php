<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class ExtratorDadosRequest
{
    private function buscaDadosRequest(Request $request)
    {
        $queryString = $request->query->all();
        $dadosOrdenacao = array_key_exists('sort', $queryString)
            ? $queryString['sort']
            : null;
        unset($queryString['sort']);
        $paginaAtual = array_key_exists('page', $queryString)
            ? $queryString['page']
            : 1;
        unset($queryString['page']);

        $itensPorPagina = array_key_exists('itensPorPagina', $queryString)
            ? $queryString['itensPorPagina']
            : 5;
        unset($queryString['itensPorPagina']);

        return [$queryString, $dadosOrdenacao, $paginaAtual, $itensPorPagina];
    }

    public function buscaDadosFiltro(Request $request)
    {
        [$filterData, , ] = $this->buscaDadosRequest($request);
        return $filterData;
    }    

    public function buscaDadosOrdenacao(Request $request)
    {
        [, $orderData, ] = $this->buscaDadosRequest($request);
        return $orderData;
    }

    public function buscaDadosPaginacao(Request $request)
    {
        [, , $paginationData] = $this->buscaDadosRequest($request);
        return $paginationData;
    }
}

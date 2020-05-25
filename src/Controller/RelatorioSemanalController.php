<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RelatorioSemanalController{


    /**
     * @Route("/distribuicaoesforco")
     */    
    public function resumoAproveitamento(Request $request):Response
    {
        $pathInfo = $request->getPathInfo();
        
        //PARAMETRO ESPECIFICO
        //$paremetro = $request->query->get('parametro');

        //TODOS OS PARAMETROS
        $paremetro = $request->query->all();

        $resumo = [
            "Categoria"=> "PROJETO",
            "TotalDePontos"=>30,
            "PercentualDePontos"=>"30%",
            "TotalDeAtividades"=>5,
            "QuantidadeDeAplicacoes"=>2,
            "Planejado"=>4,
            "PathInfo"=> $pathInfo,
            "Parametro"=> $paremetro                             
        ];
        return new JsonResponse($resumo);
    }

}
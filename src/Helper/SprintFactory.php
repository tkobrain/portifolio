<?php

namespace App\Helper;

use App\Entity\Sprint;

class SprintFactory implements EntityFactoryInterface
{

    public function createEntity(string $json): Sprint
    {
        $dadosEmJson = json_decode($json);

        $this->checkAllProperties($dadosEmJson);

        $sprint = new Sprint();

        $dataInicio = new \DateTime($dadosEmJson->DataInicioSprint);
        $dataFim = new \DateTime($dadosEmJson->DataFimSprint);
        $dataImportacao = (!empty($dadosEmJson->DataImportacao))?new \DateTime($dadosEmJson->DataImportacao):null;
        

        //Melhorar
        If(property_exists($dadosEmJson, 'Id'))
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
   
    private function checkAllProperties(object $objetoJson): void
    {
        If(property_exists($objetoJson, 'Id'))
        {
            if (!property_exists($objetoJson, 'Id')) {
                throw new EntityFactoryException('Sprint precisa de Id');
            }
    
            if (!property_exists($objetoJson, 'DataInicioSprint')) {
                throw new EntityFactoryException('Sprint precisa de uma data de início');
            }
            
            if (!property_exists($objetoJson, 'DataFimSprint')) {
                throw new EntityFactoryException('Sprint precisa de uma data de fim');
            }
    
            if (!property_exists($objetoJson, 'DataImportacao')) {
                throw new EntityFactoryException('Sprint precisa de uma data de importação');
            }          
        }else{
            if (!property_exists($objetoJson, 'DataInicioSprint')) {
                throw new EntityFactoryException('Sprint precisa de uma data de início');
            }
            
            if (!property_exists($objetoJson, 'DataFimSprint')) {
                throw new EntityFactoryException('Sprint precisa de uma data de fim');
            }
    
            if (!property_exists($objetoJson, 'DataImportacao')) {
                throw new EntityFactoryException('Sprint precisa de uma data de importação');
            }                      
        }
    }    

}
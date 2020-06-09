<?php

namespace App\Controller;

use App\Entity\Sprint;
use Psr\Log\LoggerInterface;
use App\Helper\SprintFactory;
use App\Controller\BaseController;
use App\Helper\ExtratorDadosRequest;
use App\Repository\SprintRepository;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Routing\Annotation\Route;

class SprintController extends BaseController
{
    public function __construct(
        SprintFactory $sprintFactory,        
        ExtratorDadosRequest $extratorDadosRequest,
        SprintRepository $sprintRepository,
        CacheItemPoolInterface $cache,
        LoggerInterface $logger
    )
    {
        parent::__construct($sprintFactory, $extratorDadosRequest, $sprintRepository, $cache, $logger);
        $this->sprintFactory = $sprintFactory;
    }

    public function atualizaEntidadeExistente($id, $entidade)
    {
        /** @var Sprint $entidadeExistente */
        $entidadeExistente = $this->getDoctrine()->getRepository(Sprint::class)->find($id);
        if (is_null($entidadeExistente)) {
            throw new \InvalidArgumentException();
        }
        $entidadeExistente        
            ->setDataInicioSprint($entidade->getDataInicioSprint())
            ->setDataFimSprint($entidade->getDataFimSprint())
            ->setDataImportacao($entidade->getDataImportacao());

        return $entidadeExistente;
    }    

    public function cachePrefix(): string
    {
        return 'sprint_';
    }
    /**
     * @Route ("/sprints_html")
     */
    public function sprintEmHtml()
    {
        $sprints = $this->repository->findAll();

        return $this->render('Sprints.html.twig',[
            'sprints'=>$sprints
        ]);
    }

}
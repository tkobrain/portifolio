<?php

namespace App\EventListeners;

use Psr\Log\LoggerInterface;
use App\Entity\HypermidiaResponse;
use App\Helper\EntityFactoryException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionHandler implements EventSubscriberInterface
{
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['handleEntityException', 1], //Metodo a ser implementado
                ['handle404Exception', 0],
                ['handleGenericException', -10]
            ],
        ];
    }

    public function handle404Exception(ExceptionEvent $event)
    {
        if ($event->getThrowable() instanceof NotFoundHttpException) {
            $response = HypermidiaResponse::fromError($event->getThrowable())
                ->getResponse();
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            $event->setResponse($response);
        }
    }

    public function handleEntityException(ExceptionEvent $event)
    {
        if ($event->getResponse() instanceof EntityFactoryException) {
            $response = HypermidiaResponse::fromError($event->getResponse())
                ->getResponse();
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }

    public function handleGenericException(ExceptionEvent $event)
    {
       // if ($event->getResponse() instanceof EntityFactoryException) {
            $this->logger->critical('Uma exceção ocorreu {stack}',
            [
                'stack' => $event->getThrowable()->getTraceAsString()
            ]);

            $response = HypermidiaResponse::fromError($event->getThrowable());
            $event->setResponse($response->getResponse());
        //}
    }    
}

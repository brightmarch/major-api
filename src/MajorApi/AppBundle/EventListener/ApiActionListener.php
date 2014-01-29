<?php

namespace MajorApi\AppBundle\EventListener;

use MajorApi\AppBundle\Controller\ApiController;
use MajorApi\AppBundle\Controller\SecureApiInterface;
use MajorApi\AppBundle\Entity\RequestLog;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ApiActionListener
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var MajorApi\AppBundle\Entity\Application */
    private $application;

    /** @var MajorApi\AppBundle\Entity\RequestLog */
    private $requestLog;

    public function handleKernelController(FilterControllerEvent $event)
    {
        // Listens to controller events.
        if (!is_array($event->getController())) {
            return false;
        }

        $controller = $event->getController()[0];

        if ($controller instanceof ApiController) {
            // Destroy the session because the API does not need a session entry.
            $controller->get('session')->invalidate();

            // Force all requests to support application/json as an Accept header.
            $controller->resourceSupports('application/json');

            // Controllers implementing the SecureInterface require authorization.
            if ($controller instanceof SecureApiInterface) {
                $controller->resourceRequiresAuthorization();
            }

            $this->entityManager = $controller->getEntityManager();
            $this->application = $controller->getApplication();

            // If the controller actually found a valid MajorApi Application
            // from the request, log it so we can analyze run time stats.
            // @todo Turn this into a Service.
            if ($this->hasApplication()) {
                $this->requestLog = new RequestLog;
                $this->requestLog->setApplication($this->application)
                    ->setRequestMethod($controller->getRequest()->getMethod())
                    ->setRoute($controller->getKey())
                    ->setStartTime(microtime(true));

                $this->persistRequestLog();
            }
        }

        return true;
    }

    public function handleKernelResponse(FilterResponseEvent $event)
    {
        // If we have a RequestLog entity
        // add some basic information like how long the controller took
        // to run and how much memory the entire request took.
        // @todo Turn this into a service.
        if ($this->hasRequestLog()) {
            $memoryUsage = (memory_get_peak_usage() / (1024 * 1024));

            $this->requestLog
                ->setResponseCode($event->getResponse()->getStatusCode())
                ->setEndTime(microtime(true))
                ->setMemoryUsage($memoryUsage);

            $this->persistRequestLog();
        }

        return true;
    }

    private function hasApplication()
    {
        return (is_object($this->application));
    }

    private function hasRequestLog()
    {
        return (is_object($this->requestLog));
    }

    private function persistRequestLog()
    {
        $entityManager = $this->entityManager;
        $entityManager->persist($this->requestLog);
        $entityManager->flush($this->requestLog);

        return $this;
    }

}

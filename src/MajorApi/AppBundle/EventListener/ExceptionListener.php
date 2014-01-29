<?php

namespace MajorApi\AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class ExceptionListener
{

    /** @var Symfony\Component\ContainerInterface */
    private $container;

    /** @var \Exception */
    private $exception;

    public function __construct($container)
    {
        $this->container = $container;
    }

    abstract public function handleKernelException(GetResponseForExceptionEvent $event);

    protected function getContainer()
    {
        return $this->container;
    }

    protected function setException(\Exception $exception)
    {
        $this->exception = $exception;

        return $this;
    }

    protected function getException()
    {
        return $this->exception;
    }

    protected function getExceptionStatusCode()
    {
        if ($this->getException() instanceof NotFoundHttpException) {
            $statusCode = 404;
        } else {
            // If the exception code is between [100, 600), use it as an HTTP code, else default the HTTP code to 500.
            $statusCode = ($this->getExceptionCode() >= 100 && $this->getExceptionCode() < 600 ? $this->getExceptionCode() : 500);
        }

        return (int)$statusCode;
    }

    protected function getExceptionCode()
    {
        return (int)$this->getException()->getCode();
    }

    protected function getExceptionMessage()
    {
        return $this->getException()->getMessage();
    }

    protected function logException()
    {
        $this->getContainer()
            ->get('logger')
            ->err($this->getExceptionMessage());

        return $this;
    }

}

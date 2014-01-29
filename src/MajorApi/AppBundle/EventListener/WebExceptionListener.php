<?php

namespace MajorApi\AppBundle\EventListener;

use MajorApi\AppBundle\EventListener\ExceptionListener;
use MajorApi\AppBundle\Exception\WebException;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class WebExceptionListener extends ExceptionListener
{

    public function handleKernelException(GetResponseForExceptionEvent $event)
    {
        $this->setException($event->getException())
            ->logException();

        $exception = $this->getException();
        if ($exception instanceof WebException) {
            // Web exceptions thrown by the application itself can redirect to an error page, so they are handled differently.
            $this->getContainer()
                ->get('session')
                ->setFlash('error', $this->getExceptionMessage());

            $redirect = $this->getContainer()
                ->get('router')
                ->generate($exception->getRedirect(), $exception->getRedirectParameters());

            $response = new RedirectResponse($redirect, 301);
        } else {
            // If the exception is more general or thrown by Symfony, just send them to a generic error page.
            $parameters = ['exception' => $exception];
            $template = 'MajorApiAppBundle:WebError:error.html.twig';

            $error = $this->getContainer()
                ->get('templating')
                ->render($template, $parameters);

            $response = new Response($error, $this->getExceptionStatusCode());
        }

        // Symfony defaults to HTTP 1.0 for some reason so we force HTTP 1.1 because we're from this century.
        $response->setProtocolVersion('1.1');
        $event->setResponse($response);

        return true;
    }

}

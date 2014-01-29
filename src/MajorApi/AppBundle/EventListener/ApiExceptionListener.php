<?php

namespace MajorApi\AppBundle\EventListener;

use MajorApi\AppBundle\EventListener\ExceptionListener;

use Brightmarch\RestEasy\Exception\HttpException;
use Brightmarch\RestEasy\Exception\HttpUnauthorizedException;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;

class ApiExceptionListener extends ExceptionListener
{

    public function handleKernelException(GetResponseForExceptionEvent $event)
    {
        $this->setException($event->getException())->logException();

        $pathInfo = $this->getContainer()
            ->get('request')
            ->getPathInfo();

        // If the path begins with /api, then we render a different error page and set some additional headers.
        if (0 === stripos($pathInfo, '/api')) {
            $parameters = [
                'httpCode' => $this->getExceptionStatusCode(),
                'message' => $this->getExceptionMessage(),
                'violations' => $this->getExceptionViolations()
            ];

            $template = 'MajorApiAppBundle:ApiError:error.json.twig';

            $errorJson = $this->getContainer()
                ->get('templating')
                ->render($template, $parameters);

            $jsonDecoded = json_decode($errorJson);
            $jsonEncoded = json_encode($jsonDecoded);

            // Unfortunately some code is duplicated here as in the REST controllers.
            $memoryUsage = round((memory_get_peak_usage() / 1048576), 4);

            $response = new Response($jsonEncoded, $this->getExceptionStatusCode());
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('X-Memory-Usage', $memoryUsage);

            // In a browser, this header would show a username/password box to give
            // the user a chance to authenticate themselves.
            if ($this->getException() instanceof HttpUnauthorizedException) {
                $response->headers->set('WWW-Authenticate', 'Basic realm=MajorApi Secure Resource');
            }

            $response->setProtocolVersion('1.1');
            $event->setResponse($response);
        }

        return true;
    }

    public function getExceptionMessage()
    {
        $message = "The Major API failed to complete the request. Please try your request again.";

        if ($this->isHttpException()) {
            $message = $this->getException()->getMessage();
        }

        return $message;
    }

    public function getExceptionViolations()
    {
        $violations = [];

        if ($this->isHttpException()) {
            $violations = $this->getException()->getViolations();
        }

        return $violations;
    }

    private function isHttpException()
    {
        return ($this->getException() instanceof HttpException);
    }

}

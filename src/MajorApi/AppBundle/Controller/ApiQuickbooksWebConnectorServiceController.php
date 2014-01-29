<?php

namespace MajorApi\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use \SoapServer;

class ApiQuickbooksWebConnectorServiceController extends Controller 
{

    public function handleAction()
    {
        $server = new SoapServer(__DIR__.'/../Resources/data/QBWebConnectorService.wsdl');
        $server->setObject($this->get('majorapi_quickbooks_web_connector_service'));

        $response = new Response;
        $response->headers->set('Content-Type', 'text/xml');

        ob_start();
            $server->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }

}

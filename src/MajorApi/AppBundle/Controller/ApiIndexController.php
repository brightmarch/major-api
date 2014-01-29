<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\ApiController;

class ApiIndexController extends ApiController
{

    public function indexAction()
    {
        $this->resourceSupports('application/json', 'text/html');

        // A ?private=1 parameter exists entirely to test this endpoint as an authenticated resource.
        $private = (int)$this->getRequest()->get('private');

        if ($private) {
            $this->resourceRequiresAuthorization();
        }

        $parameters = [
            'buildDate' => $this->getContainerParameter('build_date')
        ];

        return $this->renderResource('MajorApiAppBundle:ApiIndex:index', $parameters);
    }

    public function getKey()
    {
        return 'api_index';
    }

    public function getActivitySubject()
    {
        return 'QuickBooks API';
    }

}

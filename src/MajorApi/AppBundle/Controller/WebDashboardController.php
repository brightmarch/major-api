<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\WebController;

use JMS\SecurityExtraBundle\Annotation\Secure;

class WebDashboardController extends WebController
{

    /** @Secure(roles="ROLE_ACCOUNT") */
    public function indexAction()
    {
        $parameters = [
            'application' => $this->getAccount()->getPrimaryApplication(),
            'activities' => $this->getService()->findLatest(50)
        ];

        return $this->render('MajorApiAppBundle:WebDashboard:index.html.twig', $parameters);
    }

    private function getService()
    {
        $service = $this->get('majorapi_activity_finder_service')
            ->setAccount($this->getAccount());

        return $service;
    }

}

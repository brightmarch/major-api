<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\WebController;

class WebIndexController extends WebController
{

    public function indexAction()
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('majorapi_web_dashboard'));
        }

        return $this->render('MajorApiAppBundle:WebIndex:index.html.twig');
    }

}

<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\WebController;

class WebDevelopersController extends WebController
{

    public function indexAction($page)
    {
        $view = sprintf('MajorApiAppBundle:WebDevelopers:%s.html.twig', $page);

        return $this->render($view);
    }

}

<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\WebController;

class WebPageController extends WebController
{

    public function indexAction($page)
    {
        $view = sprintf('MajorApiAppBundle:WebPages:%s.html.twig', $page);

        return $this->render($view);
    }

}

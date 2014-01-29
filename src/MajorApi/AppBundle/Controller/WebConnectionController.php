<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\WebController;

class WebConnectionController extends WebController
{

    public function indexAction()
    {
        return $this->render('MajorApiAppBundle:WebConnection:index.html.twig');
    }

}

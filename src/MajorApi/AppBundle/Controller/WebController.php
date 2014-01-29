<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\Mixin\GetterMixin;
use MajorApi\AppBundle\Controller\Mixin\MessagingMixin;

abstract class WebController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{

    use GetterMixin;
    use MessagingMixin;

    public function getAccount()
    {
        return $this->getUser();
    }

}

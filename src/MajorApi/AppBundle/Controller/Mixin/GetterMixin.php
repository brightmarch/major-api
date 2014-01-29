<?php

namespace MajorApi\AppBundle\Controller\Mixin;

trait GetterMixin
{

    public function getContainer()
    {
        return $this->container;
    }

    public function getContainerParameter($parameter)
    {
        return $this->getContainer()->getParameter($parameter);
    }

    public function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    public function getAccountId()
    {
        return (int)$this->getAccount()->getId();
    }

    public function getValidator()
    {
        return $this->get('validator');
    }

}

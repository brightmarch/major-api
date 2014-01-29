<?php

namespace MajorApi\AppBundle\Library\Quickbooks\Command;

use MajorApi\AppBundle\Library\Quickbooks\Command\AbstractCommand;

class CustomerAddCommand extends AbstractCommand
{

    public function getXml()
    {
        $search = [
            'applicationId' => $this->getApplicationId(),
            'token' => null
        ];

        $quickbooksCustomers = $this->getEntityManager()
            ->getRepository('MajorApiAppBundle:QuickbooksCustomer')
            ->findBy($search);

        $view = 'MajorApiAppBundle:ApiQbxml:customers-add.xml.twig';

        return $this->getTwig()->render($view, ['quickbooksCustomers' => $quickbooksCustomers]);
    }

}

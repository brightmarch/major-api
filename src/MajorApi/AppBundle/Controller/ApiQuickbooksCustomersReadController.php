<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\ApiController;
use MajorApi\AppBundle\Controller\SecureApiInterface;
use MajorApi\AppBundle\Library\Service\Quickbooks\CustomerFinderService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerNotFoundException;

use Brightmarch\RestEasy\Exception\HttpNotFoundException;

class ApiQuickbooksCustomersReadController extends ApiController
    implements SecureApiInterface
{

    public function readAction($customerName)
    {
        try {
            $view = 'MajorApiAppBundle:ApiQuickbooks:customers';
            $activityMessage = "Successfully found QuickBooks Customer with the name %s.";

            $quickbooksCustomer = $this->getService()
                ->findByName($customerName);

            $this->getActivityManagerService()
                ->saveMessage($this->getActivitySubject(), sprintf($activityMessage, $quickbooksCustomer->getName()));

            return $this->renderResource($view, ['quickbooksCustomers' => [$quickbooksCustomer]]);
        } catch (CustomerNotFoundException $e) {
            $this->getActivityManagerService()
                ->saveWarning($this->getActivitySubject(), $e->getMessage());

            throw new HttpNotFoundException($e->getMessage());
        }
    }

    public function getKey()
    {
        return 'api_quickbooks_customers_read';
    }

    public function getActivitySubject()
    {
        return 'QuickBooks Customer API';
    }

    private function getService()
    {
        $service = $this->get('majorapi_quickbooks_customer_finder_service')
            ->setApplication($this->getApplication());

        return $service;
    }

}

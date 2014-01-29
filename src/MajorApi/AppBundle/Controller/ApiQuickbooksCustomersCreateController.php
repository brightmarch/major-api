<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\ApiController;
use MajorApi\AppBundle\Controller\SecureApiInterface;

use MajorApi\AppBundle\Library\Service\Quickbooks\CustomerCreatorService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerExistsException;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerInvalidCreationException;

use Brightmarch\RestEasy\Exception\HttpBadSyntaxException;
use Brightmarch\RestEasy\Exception\HttpConflictException;

class ApiQuickbooksCustomersCreateController extends ApiController
    implements SecureApiInterface
{

    public function createAction()
    {
        try {
            $view = 'MajorApiAppBundle:ApiQuickbooks:customers';
            $activityMessage = "Successfully created QuickBooks Customer with the name %s.";

            $quickbooksCustomer = $this->getService()->persist();

            $this->getActivityManagerService()
                ->saveMessage($this->getActivitySubject(), sprintf($activityMessage, $quickbooksCustomer->getName()));

            return $this->renderCreatedResource($view, ['quickbooksCustomers' => [$quickbooksCustomer]]);
        } catch (CustomerExistsException $e) {
            $this->getActivityManagerService()
                ->saveWarning($this->getActivitySubject(), $e->getMessage());

            throw new HttpConflictException($e->getMessage());
        } catch (CustomerInvalidCreationException $e) {
            $this->getActivityManagerService()
                ->saveAlert($this->getActivitySubject(), $e->getMessage());

            throw new HttpBadSyntaxException($e->getMessage(), $e->getViolations());
        }
    }

    public function getKey()
    {
        return 'api_quickbooks_customers_create';
    }

    public function getActivitySubject()
    {
        return 'QuickBooks Customer API';
    }

    private function getService()
    {
        $service = new CustomerCreatorService($this->getContainer(), $this->getServiceDataBridge());
        $service->setApplication($this->getApplication());

        return $service;
    }

}

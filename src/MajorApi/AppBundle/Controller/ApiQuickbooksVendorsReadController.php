<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\ApiController;
use MajorApi\AppBundle\Controller\SecureApiInterface;
use MajorApi\AppBundle\Library\Service\Quickbooks\VendorFinderService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\VendorNotFoundException;

use Brightmarch\RestEasy\Exception\HttpNotFoundException;

class ApiQuickbooksVendorsReadController extends ApiController
    implements SecureApiInterface
{

    public function readAction($vendorName)
    {
        try {
            $view = 'MajorApiAppBundle:ApiQuickbooks:vendors';
            $activityMessage = "Successfully found QuickBooks Vendor with the name %s.";

            $quickbooksVendor = $this->getService()
                ->findByName($vendorName);

            $this->getActivityManagerService()
                ->saveMessage($this->getActivitySubject(), sprintf($activityMessage, $quickbooksVendor->getName()));

            return $this->renderResource($view, ['quickbooksVendors' => [$quickbooksVendor]]);
        } catch (VendorNotFoundException $e) {
            $this->getActivityManagerService()
                ->saveWarning($this->getActivitySubject(), $e->getMessage());

            throw new HttpNotFoundException($e->getMessage());
        }
    }

    public function readAllAction()
    {
        $view = 'MajorApiAppBundle:ApiQuickbooks:vendors';
        $activityMessage = "Successfully found %d QuickBooks Vendors.";

        $quickbooksVendors = $this->getService()
            ->findAll();

        $this->getActivityManagerService()
            ->saveMessage($this->getActivitySubject(), sprintf($activityMessage, $quickbooksVendors->count()));

        return $this->renderResource($view, ['quickbooksVendors' => $quickbooksVendors]);
    }

    public function getKey()
    {
        return 'api_quickbooks_vendor_read';
    }

    public function getActivitySubject()
    {
        return 'QuickBooks Vendor API';
    }

    private function getService()
    {
        $service = $this->get('majorapi_quickbooks_vendor_finder_service')
            ->setApplication($this->getApplication());

        return $service;
    }

}

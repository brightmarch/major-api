<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\ApiController;
use MajorApi\AppBundle\Controller\SecureApiInterface;
use MajorApi\AppBundle\Library\Service\Quickbooks\InvoiceCreatorService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerNotFoundException;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\InvoiceExistsException;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\InvoiceInvalidCreationException;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\InvoiceInvalidTypeException;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\ItemNotFoundException;

use Brightmarch\RestEasy\Exception\HttpBadSyntaxException;
use Brightmarch\RestEasy\Exception\HttpConflictException;
use Brightmarch\RestEasy\Exception\HttpPreconditionFailedException;

class ApiQuickbooksInvoicesCreateController extends ApiController
    implements SecureApiInterface
{

    public function createAction()
    {
        try {
            $view = 'MajorApiAppBundle:ApiQuickbooks:invoices';
            $activityMessage = "Successfully created QuickBooks Invoice with the reference number %s.";

            $quickbooksInvoice = $this->getService()->persist();

            $this->getActivityManagerService()
                ->saveMessage($this->getActivitySubject(), sprintf($activityMessage, $quickbooksInvoice->getRefNumber()));

            return $this->renderCreatedResource($view, ['quickbooksInvoices' => [$quickbooksInvoice]]);
        } catch (CustomerNotFoundException $e) {
            $this->getActivityManagerService()
                ->saveWarning($this->getActivitySubject(), $e->getMessage());

            throw new HttpPreconditionFailedException($e->getMessage());
        } catch (InvoiceExistsException $e) {
            $this->getActivityManagerService()
                ->saveWarning($this->getActivitySubject(), $e->getMessage());

            throw new HttpConflictException($e->getMessage());
        } catch (InvoiceInvalidCreationException $e) {
            $this->getActivityManagerService()
                ->saveAlert($this->getActivitySubject(), $e->getMessage());

            throw new HttpBadSyntaxException($e->getMessage(), $e->getViolations());
        } catch (ItemNotFoundException $e) {
            $this->getActivityManagerService()
                ->saveWarning($this->getActivitySubject(), $e->getMessage());

            throw new HttpPreconditionFailedException($e->getMessage());
        }
    }

    public function getKey()
    {
        return 'api_quickbooks_invoices_create';
    }

    public function getActivitySubject()
    {
        return 'QuickBooks Invoice API';
    }

    private function getService()
    {
        $service = new InvoiceCreatorService($this->getContainer(), $this->getServiceDataBridge());
        $service->setApplication($this->getApplication());

        return $service;
    }

}

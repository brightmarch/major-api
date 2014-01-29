<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\ApiController;
use MajorApi\AppBundle\Controller\SecureApiInterface;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\InvoiceNotFoundException;

use Brightmarch\RestEasy\Exception\HttpNotFoundException;

class ApiQuickbooksInvoicesReadController extends ApiController
    implements SecureApiInterface
{

    public function readAction($refNumber)
    {
        try {
            $view = 'MajorApiAppBundle:ApiQuickbooks:invoices';
            $activityMessage = "Successfully found QuickBooks Invoice with the reference number %s.";

            $quickbooksInvoice = $this->getService()
                ->findByRefNumber($refNumber);

            $this->getActivityManagerService()
                ->saveMessage($this->getActivitySubject(), sprintf($activityMessage, $refNumber));

            return $this->renderResource($view, ['quickbooksInvoices' => [$quickbooksInvoice]]);
        } catch (InvoiceNotFoundException $e) {
            $this->getActivityManagerService()
                ->saveWarning($this->getActivitySubject(), $e->getMessage());

            throw new HttpNotFoundException($e->getMessage());
        }
    }

    public function getKey()
    {
        return 'api_quickbooks_invoices_read';
    }

    public function getActivitySubject()
    {
        return 'QuickBooks Invoice API';
    }

    private function getService()
    {
        $service = $this->get('majorapi_quickbooks_invoice_finder_service')
            ->setApplication($this->getApplication());

        return $service;
    }

}

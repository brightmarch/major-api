<?php

namespace MajorApi\AppBundle\Library\Utility\Processor;

use MajorApi\AppBundle\Library\Utility\Processor\AbstractProcessor;
use MajorApi\AppBundle\Library\Service\DataBridge;
use MajorApi\AppBundle\Library\Service\Exception\Exception as ServiceException;
use MajorApi\AppBundle\Library\Service\Quickbooks\CustomerFinderService;
use MajorApi\AppBundle\Library\Service\Quickbooks\CustomerCreatorService;
use MajorApi\AppBundle\Library\Service\Quickbooks\InvoiceCreatorService;

class StripeChargeSucceededProcessor extends AbstractProcessor
{

    public function process()
    {
        // Create a template of what ultimately the invoice will become.
        $invoice = [
            'refNumber' => '',
            'poNumber' => '',
            'customerName' => '',
            'memo' => '',
            'invoiceLines' => [
                [
                    'itemName' => $this->getContainer()->getParameter('stripe_item_name'),
                    'quantityOrdered' => 0
                ]
            ]
        ];

        $stripeEvent = $this->getPayload();
        $stripeCharge = $stripeEvent->data->object;

        // Generate a reference number for this invoice. We have up to 99 million
        // so if they ever have more invoices than that, we'll have to figure something out.
        $quickbooksInvoiceCount = $this->getQuickbooksInvoiceCount();
        $quickbooksInvoiceCount += 1;
        $invoiceNumber = str_pad((string)$quickbooksInvoiceCount, 8, '0', STR_PAD_LEFT);

        $invoice['refNumber'] = sprintf('ST%s', $invoiceNumber);

        // The charge ID has to go into the poNumber field because
        // the refNumber field is too small for it.
        $hasChargeId = property_exists($stripeCharge, 'id');
        if ($hasChargeId) {
            $invoice['poNumber'] = $stripeCharge->id;
        }

        // Get the description and put it in the notes field.
        $hasDescription = property_exists($stripeCharge, 'description');
        if ($hasDescription) {
            $invoice['memo'] = $stripeCharge->description;
        }

        // Get the quantity ordered. Because the Stripe item has a cost
        // of $0.01, we can take the amount from the charge and use that as
        // the quantity ordered.
        $hasAmount = property_exists($stripeCharge, 'amount');
        if ($hasAmount) {
            $invoice['invoiceLines'][0]['quantityOrdered'] = (float)$stripeCharge->amount;
        }

        // If they have a customer ID or email check to see if we can find the customer.
        // Otherwise, there is not much we can do.
        $hasCustomer = property_exists($stripeCharge, 'customer');
        $hasEmail = property_exists($stripeCharge, 'email');

        $search = false;
        if ($hasCustomer && !empty($stripeCharge->customer)) {
            $search = [
                'applicationId' => $this->getApplicationId(),
                'billNote' => $stripeCharge->customer
            ];

        } elseif ($hasEmail && !empty($stripeCharge->email)) {
            $search = [
                'applicationId' => $this->getApplicationId(),
                'email' => $stripeCharge->email
            ];
        }

        if ($search) {
            $quickbooksCustomer = $this->getEntityManager()
                ->getRepository('MajorApiAppBundle:QuickbooksCustomer')
                ->findOneBy($search);

            if ($quickbooksCustomer) {
                $invoice['customerName'] = $quickbooksCustomer->getName();
            }
        }

        if (empty($invoice['customerName'])) {
            $message = "Sorry, the Stripe charge with ID %s could not be imported into QuickBooks. No valid customer could be found.";
            throw new ServiceException(sprintf($message, $invoice['poNumber']));
        }

        // Create the service and persist the customer.
        $dataBridge = new DataBridge($invoice);

        $service = new InvoiceCreatorService($this->getContainer(), $dataBridge);
        $service->setApplication($this->getApplication());
        $quickbooksInvoice = $service->persist();

        return $quickbooksInvoice;
    }

    private function getQuickbooksInvoiceCount()
    {
        $dql = "SELECT COUNT(qi.id) FROM MajorApiAppBundle:QuickbooksInvoice qi
            WHERE qi.applicationId = ?1";

        $quickbooksInvoiceCount = (int)$this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->getSingleScalarResult();

        return $quickbooksInvoiceCount;
    }

}

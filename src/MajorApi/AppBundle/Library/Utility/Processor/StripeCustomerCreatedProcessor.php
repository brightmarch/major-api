<?php

namespace MajorApi\AppBundle\Library\Utility\Processor;

use MajorApi\AppBundle\Library\Utility\Processor\AbstractProcessor;
use MajorApi\AppBundle\Library\Service\DataBridge;
use MajorApi\AppBundle\Library\Service\Quickbooks\CustomerCreatorService;

class StripeCustomerCreatedProcessor extends AbstractProcessor
{

    public function process()
    {
        // Create a template of what ultimately the customer will become.
        $customer = [
            'name' => '',
            'billAddress1' => '',
            'billAddress2' => '',
            'billCity' => '',
            'billState' => '',
            'billPostalCode' => '',
            'billCountry' => '',
            'billNote' => '',
            'email' => '',
            'notes' => ''
        ];

        $stripeEvent = $this->getPayload();
        $stripeCustomer = $stripeEvent->data->object;

        // Attempt to get the name and billing information from the customer.
        $hasActiveCard = property_exists($stripeCustomer, 'active_card');
        if ($hasActiveCard) {
            $activeCard = $stripeCustomer->active_card;

            $customer['name'] = $activeCard->name;
            $customer['billAddress1'] = $activeCard->address_line1 ?: 'Missing Address #1';
            $customer['billAddress2'] = $activeCard->address_line2;
            $customer['billCity'] = $activeCard->address_city ?: 'City';
            $customer['billState'] = $activeCard->address_state ?: 'State';
            $customer['billPostalCode'] = $activeCard->address_zip ?: 'PostalCode';
            $customer['billCountry'] = $activeCard->address_country ?: 'US';

            // Attempt to somehow get the country.
            if (empty($customer['billCountry'])) {
                $customer['billCountry'] = $activeCard->country;
            }
        }

        // Get an email address.
        $hasEmail = property_exists($stripeCustomer, 'email');
        if ($hasEmail) {
            $customer['email'] = $stripeCustomer->email;
        }

        // Get the description and put it in the notes field.
        $hasDescription = property_exists($stripeCustomer, 'description');
        if ($hasDescription) {
            $customer['notes'] = $stripeCustomer->description;
        }

        // Get the id and put in billNote so the user
        // still has the ability to reference the customer in Stripe.
        $hasCustomerId = property_exists($stripeCustomer, 'id');
        if ($hasCustomerId) {
            $customer['billNote'] = $stripeCustomer->id;
        }

        // If there is no name, make one up.
        if (empty($customer['name'])) {
            $quickbooksCustomerCount = $this->getQuickbooksCustomerCount();
            $quickbooksCustomerCount += 1;

            $customer['name'] = sprintf('Stripe Customer #%d', $quickbooksCustomerCount);
        }

        // Create the service and persist the customer.
        $dataBridge = new DataBridge($customer);

        $service = new CustomerCreatorService($this->getContainer(), $dataBridge);
        $quickbooksCustomer = $service->setApplication($this->getAccount()->getPrimaryApplication())
            ->persist();

        return $quickbooksCustomer;
    }

    private function getQuickbooksCustomerCount()
    {
        $application = $this->getAccount()
            ->getPrimaryApplication();

        $dql = "SELECT COUNT(qc.id) FROM MajorApiAppBundle:QuickbooksCustomer qc
            WHERE qc.applicationId = ?1";

        $quickbooksCustomerCount = (int)$this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $application->getId())
            ->getSingleScalarResult();

        return $quickbooksCustomerCount;
    }

}

<?php

namespace MajorApi\AppBundle\Library\Service\Quickbooks;

use MajorApi\AppBundle\Entity\QuickbooksCustomer;
use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;
use MajorApi\AppBundle\Library\Service\AbstractCreatorService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerExistsException;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\CustomerInvalidCreationException;

class CustomerCreatorService extends AbstractCreatorService
{

    /** @var MajorApi\AppBundle\Entity\QuickbooksCustomer */
    private $quickbooksCustomer;

    public function persist()
    {
        $this->normalizeAddresses()
            ->hydrateQuickbooksCustomer()
            ->checkNameIsUnique()
            ->persistEntity();

        return $this->getEntity();
    }

    public function getEntity()
    {
        if (!$this->quickbooksCustomer) {
            $this->quickbooksCustomer = new QuickbooksCustomer;
        }

        return $this->quickbooksCustomer;
    }

    public function getInvalidException()
    {
        return CustomerInvalidCreationException::create();
    }

    public function getQueueAction()
    {
        return QuickbooksEnqueuer::ACTION_CUSTOMER_ADD;
    }

    private function hydrateQuickbooksCustomer()
    {
        $dataBridge = $this->getDataBridge();

        // These are explicitly set so no data can be 
        // leaked in by accident.
        $this->getEntity()
            ->setApplication($this->getApplication())
            ->setName($dataBridge['name'])
            ->setCompanyName($dataBridge['companyName'])
            ->setSalutation($dataBridge['salutation'])
            ->setFirstName($dataBridge['firstName'])
            ->setMiddleName($dataBridge['middleName'])
            ->setLastName($dataBridge['lastName'])
            ->setJobTitle($dataBridge['jobTitle'])
            ->setBillAddress1($dataBridge['billAddress1'])
            ->setBillAddress2($dataBridge['billAddress2'])
            ->setBillAddress3($dataBridge['billAddress3'])
            ->setBillAddress4($dataBridge['billAddress4'])
            ->setBillAddress5($dataBridge['billAddress5'])
            ->setBillCity($dataBridge['billCity'])
            ->setBillState($dataBridge['billState'])
            ->setBillPostalCode($dataBridge['billPostalCode'])
            ->setBillCountry($dataBridge['billCountry'])
            ->setBillNote($dataBridge['billNote'])
            ->setShipAddress1($dataBridge['shipAddress1'])
            ->setShipAddress2($dataBridge['shipAddress2'])
            ->setShipAddress3($dataBridge['shipAddress3'])
            ->setShipAddress4($dataBridge['shipAddress4'])
            ->setShipAddress5($dataBridge['shipAddress5'])
            ->setShipCity($dataBridge['shipCity'])
            ->setShipState($dataBridge['shipState'])
            ->setShipPostalCode($dataBridge['shipPostalCode'])
            ->setShipCountry($dataBridge['shipCountry'])
            ->setShipNote($dataBridge['shipNote'])
            ->setPhone($dataBridge['phone'])
            ->setAltPhone($dataBridge['altPhone'])
            ->setFax($dataBridge['fax'])
            ->setEmail($dataBridge['email'])
            ->setEmailCc($dataBridge['emailCc'])
            ->setNotes($dataBridge['notes']);

        return $this;
    }

    private function checkNameIsUnique()
    {
        // This specifically does not use the CustomerFinderService
        // because that service will throw an exception if the customer
        // is _not_ found, which we do not want to try to catch and handle.
        $quickbooksNameToken = $this->getEntity()
            ->getQuickbooksNameToken();

        $search = [
            'applicationId' => $this->getApplicationId(),
            'quickbooksNameToken' => $quickbooksNameToken
        ];

        $quickbooksCustomer = $this->getEntityManager()
            ->getRepository('MajorApiAppBundle:QuickbooksCustomer')
            ->findOneBy($search);

        if ($quickbooksCustomer) {
            throw CustomerExistsException::create($quickbooksCustomer->getName());
        }

        return $this;
    }

    private function normalizeAddresses()
    {
        // Normalizing the addresses means that values from one address are copied
        // over to values of the other address if the other address does not have a
        // value for that field. Thus if a billAddress1 is set, and shipAddress1 is not,
        // shipAddress1 will get the value from billAddress1. The opposite is also true.
        $dataBridge = $this->getDataBridge();
        $addressPairs = [
            ['billAddress1', 'shipAddress1'], ['billAddress2', 'shipAddress2'], ['billAddress3', 'shipAddress3'],
            ['billAddress4', 'shipAddress4'], ['billAddress5', 'shipAddress5'], ['billCity', 'shipCity'],
            ['billState', 'shipState'], ['billPostalCode', 'shipPostalCode'], ['billCountry', 'shipCountry']
        ];

        foreach ($addressPairs as $addressPair) {
            list($ap0, $ap1) = $addressPair;

            if (isset($dataBridge[$ap0]) && !isset($dataBridge[$ap1])) {
                $dataBridge[$ap1] = $dataBridge[$ap0];
            } elseif (isset($dataBridge[$ap1]) && !isset($dataBridge[$ap0])) {
                $dataBridge[$ap0] = $dataBridge[$ap1];
            }
        }

        return $this;
    }

}

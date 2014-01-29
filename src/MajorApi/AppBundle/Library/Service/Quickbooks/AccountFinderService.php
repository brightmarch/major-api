<?php

namespace MajorApi\AppBundle\Library\Service\Quickbooks;

use MajorApi\AppBundle\Entity\QuickbooksAccount;
use MajorApi\AppBundle\Library\Service\AbstractFinderService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\AccountNotFoundException;

use \ArrayObject;

class AccountFinderService extends AbstractFinderService
{

    public function findByName($name)
    {
        // Set the customer name so the name token can be calculated properly in a single place only.
        $quickbooksAccount = new QuickbooksAccount;
        $quickbooksAccount->setName($name);

        $dql = "SELECT qa FROM MajorApiAppBundle:QuickbooksAccount qa
            WHERE qa.applicationId = ?1
                AND qa.quickbooksNameToken = ?2";

        $quickbooksAccount = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->setParameter(2, $quickbooksAccount->getQuickbooksNameToken())
            ->getOneOrNullResult();

        if (!$quickbooksAccount) {
            throw AccountNotFoundException::create($name);
        }

        return $quickbooksAccount;
    }

    public function findAll()
    {
        $dql = "SELECT qa FROM MajorApiAppBundle:QuickbooksAccount qa
            WHERE qa.applicationId = ?1
            ORDER BY qa.created, qa.id DESC";

        $quickbooksAccounts = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter(1, $this->getApplicationId())
            ->getResult();

        return (new ArrayObject($quickbooksAccounts));
    }

}

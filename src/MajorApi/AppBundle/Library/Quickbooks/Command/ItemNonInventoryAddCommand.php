<?php

namespace MajorApi\AppBundle\Library\Quickbooks\Command;

use MajorApi\AppBundle\Entity\QuickbooksAccount;
use MajorApi\AppBundle\Library\Quickbooks\Command\AbstractCommand;

class ItemNonInventoryAddCommand extends AbstractCommand
{

    /** @const string */
    const QUICKBOOKS_ACCOUNT_NAME = 'Sales Income';

    public function getXml()
    {
        $search = [
            'applicationId' => $this->getApplicationId(),
            'quickbooksListId' => null
        ];

        $quickbooksItems = $this->getEntityManager()
            ->getRepository('MajorApiAppBundle:QuickbooksItem')
            ->findBy($search);

        // Attempt to find an account called Sales Income. If it can not be found,
        // we'll use the account name Sales Income and hope they have not changed it.
        // Sales Income is a default account created by QuickBooks and the default account
        // items with costs associated with them are saved to. Thus, we're taking a decent
        // estimated guess here that it will exist.
        $quickbooksAccount = new QuickbooksAccount;
        $quickbooksAccount->setName(self::QUICKBOOKS_ACCOUNT_NAME);

        $search = [
            'applicationId' => $this->getApplicationId(),
            'quickbooksNameToken' => $quickbooksAccount->getQuickbooksNameToken()
        ];

        $quickbooksAccount = $this->getEntityManager()
            ->getRepository('MajorApiAppBundle:QuickbooksAccount')
            ->findOneBy($search);

        $view = 'MajorApiAppBundle:ApiQbxml:item-non-inventory-add.xml.twig';

        $parameters = [
            'quickbooksItems' => $quickbooksItems,
            'quickbooksAccount' => $quickbooksAccount,
            'quickbooksAccountName' => self::QUICKBOOKS_ACCOUNT_NAME
        ];

        return $this->getTwig()->render($view, $parameters);
    }

}

<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\ApiController;
use MajorApi\AppBundle\Controller\SecureApiInterface;
use MajorApi\AppBundle\Library\Service\Quickbooks\AccountFinderService;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\AccountNotFoundException;

use Brightmarch\RestEasy\Exception\HttpNotFoundException;

class ApiQuickbooksAccountsReadController extends ApiController
    implements SecureApiInterface
{

    public function readAction($accountName)
    {
        try {
            $view = 'MajorApiAppBundle:ApiQuickbooks:accounts';
            $activityMessage = "Successfully found QuickBooks Account with the name %s.";

            $quickbooksAccount = $this->getService()
                ->findByName($accountName);

            $this->getActivityManagerService()
                ->saveMessage($this->getActivitySubject(), sprintf($activityMessage, $accountName));

            return $this->renderResource($view, ['quickbooksAccounts' => [$quickbooksAccount]]);
        } catch (AccountNotFoundException $e) {
            $this->getActivityManagerService()
                ->saveWarning($this->getActivitySubject(), $e->getMessage());

            throw new HttpNotFoundException($e->getMessage());
        }
    }

    public function readAllAction()
    {
        $view = 'MajorApiAppBundle:ApiQuickbooks:accounts';
        $activityMessage = "Successfully found %d QuickBooks Accounts.";

        $quickbooksAccounts = $this->getService()
            ->findAll();

        $this->getActivityManagerService()
            ->saveMessage($this->getActivitySubject(), sprintf($activityMessage, $quickbooksAccounts->count()));

        return $this->renderResource($view, ['quickbooksAccounts' => $quickbooksAccounts]);
    }

    public function getKey()
    {
        return 'api_quickbooks_account_read';
    }

    public function getActivitySubject()
    {
        return 'QuickBooks Account API';
    }

    private function getService()
    {
        $service = $this->get('majorapi_quickbooks_account_finder_service')
            ->setApplication($this->getApplication());

        return $service;
    }

}

<?php

namespace MajorApi\AppBundle\Controller;

use MajorApi\AppBundle\Controller\ApiController;
use MajorApi\AppBundle\Controller\SecureApiInterface;
use MajorApi\AppBundle\Library\Service\Exception\Quickbooks\ItemNotFoundException;

use Brightmarch\RestEasy\Exception\HttpNotFoundException;

class ApiQuickbooksItemsReadController extends ApiController
    implements SecureApiInterface
{
    
    public function readAction($itemName)
    {
        try {
            $view = 'MajorApiAppBundle:ApiQuickbooks:items';
            $activityMessage = "Successfully found QuickBooks Item with the name %s.";

            $quickbooksItem = $this->getService()
                ->findByName($itemName);

            $this->getActivityManagerService()
                ->saveMessage($this->getActivitySubject(), sprintf($activityMessage, $itemName));
        
            return $this->renderResource($view, ['quickbooksItems' => [$quickbooksItem]]);
        } catch (ItemNotFoundException $e) {
            $this->getActivityManagerService()
                ->saveWarning($this->getActivitySubject(), $e->getMessage());

            throw new HttpNotFoundException($e->getMessage());
        }
    }

    public function getKey()
    {
        return 'api_quickbooks_items_read';
    }

    public function getActivitySubject()
    {
        return 'QuickBooks Item API';
    }

    private function getService()
    {
        $service = $this->get('majorapi_quickbooks_item_finder_service')
            ->setApplication($this->getApplication());

        return $service;
    }

}

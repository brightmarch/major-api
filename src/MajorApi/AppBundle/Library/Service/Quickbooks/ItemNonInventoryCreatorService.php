<?php

namespace MajorApi\AppBundle\Library\Service\Quickbooks;

use MajorApi\AppBundle\Entity\QuickbooksItem;
use MajorApi\AppBundle\Library\Quickbooks\QuickbooksEnqueuer;
use MajorApi\AppBundle\Library\Service\Quickbooks\ItemCreatorService;

class ItemNonInventoryCreatorService extends ItemCreatorService
{

    public function getQueueAction()
    {
        return QuickbooksEnqueuer::ACTION_ITEM_NON_INVENTORY_ADD;
    }

    public function getItemType()
    {
        return QuickbooksItem::TYPE_NON_INVENTORY;
    }

}

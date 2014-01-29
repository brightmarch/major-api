<?php

namespace MajorApi\AppBundle\Library\Service\Exception\Quickbooks;

use MajorApi\AppBundle\Library\Service\Exception\Exception;

class ItemExistsException extends Exception
{

    public static function create($itemName)
    {
        $message = "A QuickBooks Item with the name %s already exists. The item name must be unique.";

        return new self(sprintf($message, $itemName));
    }

}

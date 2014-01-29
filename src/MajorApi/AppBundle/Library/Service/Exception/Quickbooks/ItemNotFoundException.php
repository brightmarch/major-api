<?php

namespace MajorApi\AppBundle\Library\Service\Exception\Quickbooks;

use MajorApi\AppBundle\Library\Service\Exception\Exception;

class ItemNotFoundException extends Exception
{

    public static function create($itemName)
    {
        $message = "A QuickBooks Item with the name %s could not be found.";

        return new self(sprintf($message, $itemName));
    }

}

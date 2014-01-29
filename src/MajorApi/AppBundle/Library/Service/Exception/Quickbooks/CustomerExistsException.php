<?php

namespace MajorApi\AppBundle\Library\Service\Exception\Quickbooks;

use MajorApi\AppBundle\Library\Service\Exception\Exception;

class CustomerExistsException extends Exception
{

    public static function create($customerName)
    {
        $message = "A QuickBooks Customer with the name %s already exists. The customer name must be unique.";

        return new self(sprintf($message, $customerName));
    }

}

<?php

namespace MajorApi\AppBundle\Library\Service\Exception\Quickbooks;

use MajorApi\AppBundle\Library\Service\Exception\Exception;

class CustomerNotFoundException extends Exception
{

    public static function create($customerName)
    {
        $message = "A QuickBooks Customer with the name %s could not be found.";

        return new self(sprintf($message, $customerName));
    }

}

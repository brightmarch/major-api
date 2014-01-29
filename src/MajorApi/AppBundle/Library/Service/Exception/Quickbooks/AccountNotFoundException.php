<?php

namespace MajorApi\AppBundle\Library\Service\Exception\Quickbooks;

use MajorApi\AppBundle\Library\Service\Exception\Exception;

class AccountNotFoundException extends Exception
{

    public static function create($name)
    {
        $message = "A QuickBooks Account with the name %s could not be found.";

        return new self(sprintf($message, $name));
    }

}

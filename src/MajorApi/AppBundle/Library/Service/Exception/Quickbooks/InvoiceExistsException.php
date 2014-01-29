<?php

namespace MajorApi\AppBundle\Library\Service\Exception\Quickbooks;

use MajorApi\AppBundle\Library\Service\Exception\Exception;

class InvoiceExistsException extends Exception
{

    public static function create($refNumber)
    {
        $message = "The QuickBooks Invoice you are attempting to create with the reference number %s has already been created. The reference number must be unique.";

        return new self(sprintf($message, $refNumber));
    }

}

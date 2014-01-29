<?php

namespace MajorApi\AppBundle\Library\Service\Exception\Quickbooks;

use MajorApi\AppBundle\Library\Service\Exception\Exception;

class InvoiceNotFoundException extends Exception
{

    public static function create($refNumber)
    {
        $message = "A QuickBooks Invoice with the reference number %s could not be found.";

        return new self(sprintf($message, $refNumber));
    }

}

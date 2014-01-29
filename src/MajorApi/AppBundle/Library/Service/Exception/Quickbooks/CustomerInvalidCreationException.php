<?php

namespace MajorApi\AppBundle\Library\Service\Exception\Quickbooks;

use MajorApi\AppBundle\Library\Service\Exception\Exception;

class CustomerInvalidCreationException extends Exception
{

    public static function create()
    {
        return new self("The QuickBooks Customer can not be created because it is invalid.");
    }

}

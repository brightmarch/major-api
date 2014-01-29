<?php

namespace MajorApi\AppBundle\Library\Quickbooks\Command;

use MajorApi\AppBundle\Library\Quickbooks\Command\AbstractCommand;

class VendorQueryCommand extends AbstractCommand
{

    public function getXml()
    {
        return '<VendorQueryRq></VendorQueryRq>';
    }

}

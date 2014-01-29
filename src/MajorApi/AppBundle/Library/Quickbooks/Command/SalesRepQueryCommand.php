<?php

namespace MajorApi\AppBundle\Library\Quickbooks\Command;

use MajorApi\AppBundle\Library\Quickbooks\Command\AbstractCommand;

class SalesRepQueryCommand extends AbstractCommand
{

    public function getXml()
    {
        return '<SalesRepQueryRq></SalesRepQueryRq>';
    }

}

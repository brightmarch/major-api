<?php

namespace MajorApi\AppBundle\Library\Quickbooks\Command;

use MajorApi\AppBundle\Library\Quickbooks\Command\AbstractCommand;

class InvoiceQueryCommand extends AbstractCommand
{

    public function getXml()
    {
        return '<InvoiceQueryRq></InvoiceQueryRq>';
    }

}

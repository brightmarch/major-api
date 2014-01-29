<?php

namespace MajorApi\AppBundle\Library\Quickbooks\Command;

use MajorApi\AppBundle\Library\Quickbooks\Command\AbstractCommand;

class AccountQueryCommand extends AbstractCommand
{

    public function getXml()
    {
        return '<AccountQueryRq></AccountQueryRq>';
    }

}

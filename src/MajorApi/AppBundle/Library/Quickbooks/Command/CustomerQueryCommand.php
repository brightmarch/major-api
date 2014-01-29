<?php

namespace MajorApi\AppBundle\Library\Quickbooks\Command;

use MajorApi\AppBundle\Library\Quickbooks\Command\AbstractCommand;

class CustomerQueryCommand extends AbstractCommand
{

    public function getXml()
    {
        return '<CustomerQueryRq></CustomerQueryRq>';
    }

}

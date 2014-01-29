<?php

namespace MajorApi\AppBundle\Library\Quickbooks\Command;

use MajorApi\AppBundle\Library\Quickbooks\Command\AbstractCommand;

class HostQueryCommand extends AbstractCommand
{

    public function getXml()
    {
        return '<HostQueryRq></HostQueryRq>';
    }

}

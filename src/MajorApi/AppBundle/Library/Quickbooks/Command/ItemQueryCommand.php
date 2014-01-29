<?php

namespace MajorApi\AppBundle\Library\Quickbooks\Command;

use MajorApi\AppBundle\Library\Quickbooks\Command\AbstractCommand;

class ItemQueryCommand extends AbstractCommand
{

    public function getXml()
    {
        return '<ItemQueryRq></ItemQueryRq>';
    }

}

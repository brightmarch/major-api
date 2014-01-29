<?php

namespace MajorApi\AppBundle\Library\Service;

class Redis extends \Redis
{

    public function __construct($host, $port)
    {
        $this->connect($host, $port);
    }

}

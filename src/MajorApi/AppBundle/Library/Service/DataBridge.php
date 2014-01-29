<?php

namespace MajorApi\AppBundle\Library\Service;

use \ArrayAccess;

class DataBridge implements ArrayAccess
{

    /** @var array */
    private $data = [];

    public function __construct(array $data=[])
    {
        $this->data = $data;
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetUnset($offset)
    {
        return false;
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->data[$offset];
        }

        return null;
    }

}

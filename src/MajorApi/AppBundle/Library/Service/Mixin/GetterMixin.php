<?php

namespace MajorApi\AppBundle\Library\Service\Mixin;

trait GetterMixin
{

    public function getDataBridge()
    {
        return $this->dataBridge;
    }

    public function getValidator()
    {
        return $this->validator;
    }

}

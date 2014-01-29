<?php

namespace MajorApi\AppBundle\Library\Service\Exception;

class Exception extends \Exception
{

    /** @var array */
    private $violations = [];

    public function setViolations(array $violations)
    {
        $this->violations = $violations;

        return $this;
    }

    public function getViolations()
    {
        return $this->violations;
    }

}

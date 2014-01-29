<?php

namespace MajorApi\AppBundle\Exception;

class WebException extends \Exception
{

    /** @var string */
    private $redirect = '';

    /** @var array */
    private $redirectParameters = [];

    public function __construct($message, $redirect='', array $redirectParameters=[])
    {
        parent::__construct($message);

        $this->redirect = trim($redirect);
        $this->redirectParameters = $redirectParameters;
    }

    public function getRedirect()
    {
        return $this->redirect;
    }

    public function getRedirectParameters()
    {
        return $this->redirectParameters;
    }

}

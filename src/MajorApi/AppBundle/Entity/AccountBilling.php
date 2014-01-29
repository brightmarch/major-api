<?php

namespace MajorApi\AppBundle\Entity;

class AccountBilling
{

    /** @var string */
    protected $cardNumber;

    /** @var string */
    protected $expirationMonth;

    /** @var string */
    protected $expirationYear;

    /** @var string */
    protected $cvc;

    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    public function setExpirationMonth($expirationMonth)
    {
        $this->expirationMonth = $expirationMonth;

        return $this;
    }

    public function getExpirationMonth()
    {
        return $this->expirationMonth;
    }

    public function setExpirationYear($expirationYear)
    {
        $this->expirationYear = $expirationYear;

        return $this;
    }

    public function getExpirationYear()
    {
        return $this->expirationYear;
    }

    public function setCvc($cvc)
    {
        $this->cvc = $cvc;
    }

    public function getCvc()
    {
        return $this->cvc;
    }

}

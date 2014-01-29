<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class QuickbooksStripeEvent extends \Brightmarch\RestEasy\Entity\Entity
{

    /** @var integer */
    protected $id;

    /** @var DateTime */
    protected $created;

    /** @var DateTime */
    protected $updated;

    /** @var integer */
    protected $status = 0;

    /** @var integer */
    protected $accountId;

    /** @var string */
    protected $stripeEventId;

    /** @var string */
    protected $stripeEventPayload;

    /** @var string */
    protected $stripeEventType;

    /** @var MajorApi\AppBundle\Entity\Account */
    protected $account;

    /** @var array */
    private $eventProcessors = [
        self::STRIPE_EVENT_TYPE_CUSTOMER_CREATED => 'MajorApi\AppBundle\Library\Utility\Processor\StripeCustomerCreatedProcessor',
        self::STRIPE_EVENT_TYPE_CHARGE_SUCCEEDED => 'MajorApi\AppBundle\Library\Utility\Processor\StripeChargeSucceededProcessor'
    ];

    /** @const string */
    const STRIPE_EVENT_TYPE_CUSTOMER_CREATED = 'customer.created';

    /** @const string */
    const STRIPE_EVENT_TYPE_CHARGE_SUCCEEDED = 'charge.succeeded';

    public function onCreate()
    {
        $this->setCreated(new DateTime)
            ->setUpdated(new DateTime)
            ->enable();

        return true;
    }
    
    public function onUpdate()
    {
        $this->setUpdated(new DateTime);

        return true;
    }

    public function isProcessable()
    {
        $events = [
            self::STRIPE_EVENT_TYPE_CUSTOMER_CREATED => true,
            self::STRIPE_EVENT_TYPE_CHARGE_SUCCEEDED => true
        ];

        return array_key_exists($this->stripeEventType, $events);
    }

    public function getProcessorClass()
    {
        if ($this->isProcessable()) {
            return $this->eventProcessors[$this->stripeEventType];
        }

        return null;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return QuickbooksStripeEvent
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return QuickbooksStripeEvent
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return QuickbooksStripeEvent
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set accountId
     *
     * @param integer $accountId
     * @return QuickbooksStripeEvent
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    
        return $this;
    }

    /**
     * Get accountId
     *
     * @return integer 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set stripeEventId
     *
     * @param string $stripeEventId
     * @return QuickbooksStripeEvent
     */
    public function setStripeEventId($stripeEventId)
    {
        $this->stripeEventId = $stripeEventId;
    
        return $this;
    }

    /**
     * Get stripeEventId
     *
     * @return string 
     */
    public function getStripeEventId()
    {
        return $this->stripeEventId;
    }

    /**
     * Set stripeEventPayload
     *
     * @param string $stripeEventPayload
     * @return QuickbooksStripeEvent
     */
    public function setStripeEventPayload($stripeEventPayload)
    {
        $this->stripeEventPayload = $stripeEventPayload;
    
        return $this;
    }

    /**
     * Get stripeEventPayload
     *
     * @return string 
     */
    public function getStripeEventPayload()
    {
        return $this->stripeEventPayload;
    }

    /**
     * Set stripeEventType
     *
     * @param string $stripeEventType
     * @return QuickbooksStripeEvent
     */
    public function setStripeEventType($stripeEventType)
    {
        $this->stripeEventType = strtolower($stripeEventType);
    
        return $this;
    }

    /**
     * Get stripeEventType
     *
     * @return string 
     */
    public function getStripeEventType()
    {
        return $this->stripeEventType;
    }

    /**
     * Set account
     *
     * @param \MajorApi\AppBundle\Entity\Account $account
     * @return QuickbooksStripeEvent
     */
    public function setAccount(\MajorApi\AppBundle\Entity\Account $account = null)
    {
        $this->account = $account;
    
        return $this;
    }

    /**
     * Get account
     *
     * @return \MajorApi\AppBundle\Entity\Account 
     */
    public function getAccount()
    {
        return $this->account;
    }

}

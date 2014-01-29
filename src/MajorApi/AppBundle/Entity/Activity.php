<?php

namespace MajorApi\AppBundle\Entity;

use MajorApi\AppBundle\Library\Utility\StringUtility;

use Doctrine\Common\Collections\ArrayCollection;

use \DateTime;

class Activity extends \Brightmarch\RestEasy\Entity\Entity
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
    protected $type;

    /** @var string */
    protected $subject;

    /** @var string */
    protected $message;

    /** @var MajorApi\AppBundle\Entity\Account */
    protected $account;

    /** @const string */
    const TYPE_MESSAGE = 'message';

    /** @const string */
    const TYPE_WARNING = 'warning';

    /** @const string */
    const TYPE_ALERT = 'alert';

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

    /**
     * Gets the name of the CSS class from the type.
     *
     * @return string
     */
    public function getCssClassFromType()
    {
        $classes = [
            self::TYPE_MESSAGE => 'normal',
            self::TYPE_WARNING => 'warning',
            self::TYPE_ALERT => 'alert'
        ];

        if (array_key_exists($this->type, $classes)) {
            return $classes[$this->type];
        }

        return $classes[self::TYPE_MESSAGE];
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
     * @return Activity
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
     * @return Activity
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
     * @return Activity
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
     * @return Activity
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
     * Set type
     *
     * @param string $type
     * @return Activity
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return Activity
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    
        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Activity
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set account
     *
     * @param \MajorApi\AppBundle\Entity\Account $account
     * @return Activity
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

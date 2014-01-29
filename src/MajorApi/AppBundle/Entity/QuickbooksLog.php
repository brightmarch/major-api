<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class QuickbooksLog extends \Brightmarch\RestEasy\Entity\Entity
{

    /** @var integer */
    protected $id;

    /** @var DateTime */
    protected $created;

    /** @var DateTime */
    protected $updated;

    /** @var DateTime */
    protected $dismissed;

    /** @var integer */
    protected $status = 0;

    /** @var integer */
    protected $applicationId;

    /** @var string */
    protected $type;

    /** @var string */
    protected $message;

    /** @var string */
    protected $subject;

    /** @var MajorApi\AppBundle\Entity\Application */
    protected $application;

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
     * @return QuickbooksLog
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
     * @return QuickbooksLog
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
     * Set dismissed
     *
     * @param \DateTime $dismissed
     * @return QuickbooksLog
     */
    public function setDismissed($dismissed)
    {
        $this->dismissed = $dismissed;
    
        return $this;
    }

    /**
     * Get dismissed
     *
     * @return \DateTime 
     */
    public function getDismissed()
    {
        return $this->dismissed;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return QuickbooksLog
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
     * Set applicationId
     *
     * @param integer $applicationId
     * @return QuickbooksLog
     */
    public function setApplicationId($applicationId)
    {
        $this->applicationId = $applicationId;
    
        return $this;
    }

    /**
     * Get applicationId
     *
     * @return integer 
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return QuickbooksLog
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
     * Set message
     *
     * @param string $message
     * @return QuickbooksLog
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
     * Set subject
     *
     * @param string $subject
     * @return QuickbooksLog
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
     * Set application
     *
     * @param \MajorApi\AppBundle\Entity\Application $application
     * @return QuickbooksLog
     */
    public function setApplication(\MajorApi\AppBundle\Entity\Application $application = null)
    {
        $this->application = $application;
    
        return $this;
    }

    /**
     * Get application
     *
     * @return \MajorApi\AppBundle\Entity\Application 
     */
    public function getApplication()
    {
        return $this->application;
    }

}

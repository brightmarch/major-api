<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class QuickbooksQueue extends \Brightmarch\RestEasy\Entity\Entity
{

    /** @var integer */
    protected $id;

    /** @var DateTime */
    protected $created;

    /** @var DateTime */
    protected $updated;

    /** @var DateTime */
    protected $processed;

    /** @var integer */
    protected $status = 0;

    /** @var integer */
    protected $applicationId;

    /** @var string */
    protected $command;

    /** @var string */
    protected $persister;

    /** @var string */
    protected $token;

    /** @var string */
    protected $requestXml;

    /** @var string */
    protected $isIpp = false;

    /** @var string */
    protected $queueToken;

    /** @var MajorApi\AppBundle\Entity\Application */
    protected $application;

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
     * @return QuickbooksQueue
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
     * @return QuickbooksQueue
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
     * Set processed
     *
     * @param \DateTime $processed
     * @return QuickbooksQueue
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;
    
        return $this;
    }

    /**
     * Get processed
     *
     * @return \DateTime 
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return QuickbooksQueue
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
     * @return QuickbooksQueue
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
     * Set command
     *
     * @param string $command
     * @return QuickbooksQueue
     */
    public function setCommand($command)
    {
        $this->command = $command;
    
        return $this;
    }

    /**
     * Get command
     *
     * @return string 
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set persister
     *
     * @param string $persister
     * @return QuickbooksQueue
     */
    public function setPersister($persister)
    {
        $this->persister = $persister;
    
        return $this;
    }

    /**
     * Get persister
     *
     * @return string 
     */
    public function getPersister()
    {
        return $this->persister;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return QuickbooksQueue
     */
    public function setToken($token)
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set requestXml
     *
     * @param string $requestXml
     * @return QuickbooksQueue
     */
    public function setRequestXml($requestXml)
    {
        $this->requestXml = trim($requestXml);
    
        return $this;
    }

    /**
     * Get requestXml
     *
     * @return string 
     */
    public function getRequestXml()
    {
        return $this->requestXml;
    }

    /**
     * Set isIpp
     *
     * @param boolean $isIpp
     * @return QuickbooksQueue
     */
    public function setIsIpp($isIpp)
    {
        $this->isIpp = (bool)$isIpp;
    
        return $this;
    }

    /**
     * Get isIpp
     *
     * @return boolean 
     */
    public function getIsIpp()
    {
        return $this->isIpp;
    }

    /**
     * Set queueToken
     *
     * @param string $queueToken
     * @return QuickbooksQueue
     */
    public function setQueueToken($queueToken)
    {
        $this->queueToken = $queueToken;
    
        return $this;
    }

    /**
     * Get queueToken
     *
     * @return string 
     */
    public function getQueueToken()
    {
        return $this->queueToken;
    }

    /**
     * Set application
     *
     * @param \MajorApi\AppBundle\Entity\Application $application
     * @return QuickbooksQueue
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

<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class RequestLog extends \Brightmarch\RestEasy\Entity\Entity
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
    protected $applicationId;

    /** @var string */
    protected $requestMethod;

    /** @var integer */
    protected $responseCode = 0;

    /** @var string */
    protected $route;

    /** @var float */
    protected $startTime = 0.0;

    /** @var float */
    protected $endTime = 0.0;

    /** @var float */
    protected $requestTime = 0.0;

    /** @var float */
    protected $memoryUsage = 0.0;

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

        if ($this->endTime > 0) {
            $this->requestTime = round($this->endTime - $this->startTime, 5);
        }

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
     * @return RequestLog
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
     * @return RequestLog
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
     * @return RequestLog
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
     * @return RequestLog
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
     * Set requestMethod
     *
     * @param string $requestMethod
     * @return RequestLog
     */
    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    
        return $this;
    }

    /**
     * Get requestMethod
     *
     * @return string 
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * Set responseCode
     *
     * @param integer $responseCode
     * @return RequestLog
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
    
        return $this;
    }

    /**
     * Get responseCode
     *
     * @return integer 
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return RequestLog
     */
    public function setRoute($route)
    {
        $this->route = $route;
    
        return $this;
    }

    /**
     * Get route
     *
     * @return string 
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set startTime
     *
     * @param float $startTime
     * @return RequestLog
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return float 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param float $endTime
     * @return RequestLog
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    
        return $this;
    }

    /**
     * Get endTime
     *
     * @return float 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set requestTime
     *
     * @param float $requestTime
     * @return RequestLog
     */
    public function setRequestTime($requestTime)
    {
        $this->requestTime = $requestTime;
    
        return $this;
    }

    /**
     * Get requestTime
     *
     * @return float 
     */
    public function getRequestTime()
    {
        return $this->requestTime;
    }

    /**
     * Set memoryUsage
     *
     * @param float $memoryUsage
     * @return RequestLog
     */
    public function setMemoryUsage($memoryUsage)
    {
        $this->memoryUsage = round($memoryUsage, 5);
    
        return $this;
    }

    /**
     * Get memoryUsage
     *
     * @return float 
     */
    public function getMemoryUsage()
    {
        return $this->memoryUsage;
    }

    /**
     * Set application
     *
     * @param \MajorApi\AppBundle\Entity\Application $application
     * @return QuickbooksAccount
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

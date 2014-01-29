<?php

namespace MajorApi\AppBundle\Entity;

use \DateTime;

class QuickbooksResponse extends \Brightmarch\RestEasy\Entity\Entity
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
    protected $responseXml;

    /** @var integer */
    protected $xmlSize = 0;

    /** @var integer */
    protected $recordCount = 0;

    /** @var float */
    protected $processTime = 0.0;

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
     * @return QuickbooksResponse
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
     * @return QuickbooksResponse
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
     * @return QuickbooksResponse
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
     * @return QuickbooksResponse
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
     * @return QuickbooksResponse
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
     * Set responseXml
     *
     * @param string $responseXml
     * @return QuickbooksResponse
     */
    public function setResponseXml($responseXml)
    {
        $this->responseXml = $responseXml;
    
        return $this;
    }

    /**
     * Get responseXml
     *
     * @return string 
     */
    public function getResponseXml()
    {
        return $this->responseXml;
    }

    /**
     * Set xmlSize
     *
     * @param integer $xmlSize
     * @return QuickbooksResponse
     */
    public function setXmlSize($xmlSize)
    {
        $this->xmlSize = (int)$xmlSize;
    
        return $this;
    }

    /**
     * Get xmlSize
     *
     * @return integer 
     */
    public function getXmlSize()
    {
        return $this->xmlSize;
    }

    /**
     * Set recordCount
     *
     * @param integer $recordCount
     * @return QuickbooksResponse
     */
    public function setRecordCount($recordCount)
    {
        $this->recordCount = (int)$recordCount;
    
        return $this;
    }

    /**
     * Get recordCount
     *
     * @return integer 
     */
    public function getRecordCount()
    {
        return $this->recordCount;
    }

    /**
     * Set processTime
     *
     * @param float $processTime
     * @return QuickbooksResponse
     */
    public function setProcessTime($processTime)
    {
        $this->processTime = (float)$processTime;
    
        return $this;
    }

    /**
     * Get processTime
     *
     * @return float 
     */
    public function getProcessTime()
    {
        return $this->processTime;
    }

    /**
     * Set application
     *
     * @param \MajorApi\AppBundle\Entity\Application $application
     * @return QuickbooksResponse
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
